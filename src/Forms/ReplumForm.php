<?php
/**
 * This file is part of Replum: the web widget framework.
 *
 * Copyright (c) Dennis Birkholz <dennis@birkholz.org>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Replum\Forms;

use Replum\Events\WidgetOnChangeEvent;
use Replum\Events\WidgetOnSubmitEvent;
use Replum\HtmlFactory as Html;
use Replum\Html\Form;
use Replum\Html\HtmlElement;

abstract class ReplumForm
{
    /**
     * @var self
     */
    private $parent;

    /**
     * @var string
     */
    private $prefix;

    /**
     * @var Form
     */
    private $form;

    /**
     * @var FieldDefinition[]
     */
    private $fields = [];


    public function __construct(string $prefix = null)
    {
        $this->prefix = $prefix;
    }

    /**
     * @return self
     */
    final public function getParent() : self
    {
        return $this->parent;
    }

    /**
     * @return bool
     */
    final public function hasParent() : bool
    {
        return ($this->parent !== null);
    }

    /**
     * @return static $this
     */
    final protected function setParent(self $parent) : self
    {
        $this->parent = $parent;
        return $this;
    }

    /**
     * @return string
     */
    final public function getPrefix() : string
    {
        return $this->prefix;
    }

    /**
     * @return bool
     */
    final public function hasPrefix() : bool
    {
        return ($this->prefix !== null);
    }

    /**
     * @return static $this
     */
    final protected function setPrefix(string $prefix) : self
    {
        $this->prefix = $prefix;
        return $this;
    }

    /**
     * @return Form
     */
    public function getForm() : Form
    {
        if ($this->hasParent()) {
            return $this->getParent()->getForm();
        }

        if ($this->form === null) {
            $this->form = new Form();
            $this->form->needID();
            $this->form->setMethod(Form::METHOD_POST);
            $this->form->onSubmit([$this, 'handleFormSubmit']);
        }

        return $this->form;
    }

    /**
     * @return static $this
     */
    public function addField(FieldDefinition $fieldDefinition) : self
    {
        if (isset($this->fields[$fieldDefinition->getName()])) {
            throw new \InvalidArgumentException(\sprintf('The field "%s" is already defined!', $fieldDefinition->getName()));
        }

        $this->fields[$fieldDefinition->getName()] = $fieldDefinition;
        return $this;
    }

    protected function getFields() : \Traversable
    {
        return $this->fields;
    }

    public function getField(string $name)
    {
        return $this->fields[$name];
    }

    //abstract function build() : HtmlElement;

    public function addEmbeddedForm(string $prefix, ReplumForm $embeddedForm)
    {
        $fullPrefix = ($this->hasPrefix() ? $this->getPrefix() . '.' : '') . $prefix;

        if ($embeddedForm->hasPrefix() && $embeddedForm->getPrefix() !== $fullPrefix) {
            throw new \InvalidArgumentException('Prefix of embedded form and desired prefix do not match!');
        }

        $embeddedForm->setParent($this);
        $embeddedForm->setPrefix($fullPrefix);
        $this->fields[$prefix] = $embeddedForm;
    }

    private $formGroups = [];
    private $labels = [];
    private $inputs = [];
    private $errorDivs = [];

    protected function getRealFieldName(string $fieldName)
    {
        if (!$this->hasPrefix()) {
            return $fieldName;
        }

        $parts = \explode('.', $this->getPrefix());
        $parts[] = $fieldName;

        $r = \array_shift($parts);
        foreach ($parts as $part) {
            $r .= '[' . $part . ']';
        }

        return $r;
    }

    public function createFormGroup(string $fieldName) : HtmlElement
    {
        $field = $this->getField($fieldName);

        $formGroup = $this->formGroups[$fieldName] = Html::div()
            ->needID()
            ->addClass('form-group')
        ;

        $input = $this->inputs[$fieldName] = Html::textInput()
            ->needID()
            ->setName($this->getRealFieldName($fieldName))
            ->addClass('form-control')
            ->addClass('boxed')
            ->onChange([$this, 'handleFormChange'])
        ;

        if ($field->hasLabel()) {
            $label = $this->labels[$fieldName] = Html::label()
                ->add(Html::text($field->getLabel()))
                ->setFor($input)
            ;
            $formGroup->add($label);
        }

        if ($field->hasPlaceholder()) {
            $input->setPlaceHolder($field->getPlaceholder());
        }

        if ($field->getRequired()) {
            $formGroup->add(
                Html::div()
                    ->addClass('required-field-block')
                    ->add(
                        Html::div()
                            ->addClass('required-icon')
                            ->setTitle("Feld ist erforderlich")
                            ->addData('toggle', 'tooltip')
                            ->addData('offset', '4')
                            ->addData('placement', 'left')
                            ->add(
                                Html::div()
                                    ->addClass('text')
                                    ->add(Html::text('*'))
                            )
                    )
            );
        }

        $formGroup->add($input);

        return $formGroup;
    }

    protected function getInternalFieldName(string $realFieldName) : string
    {
        return \str_replace(['[', ']'], ['.', ''], $realFieldName);
    }

    protected function getLocalFieldName(string $externalFieldName) : string
    {
        return \substr($externalFieldName, ($this->hasPrefix() ? \strlen($this->getPrefix())+1 : 0));
    }

    public function handleFormChange(WidgetOnChangeEvent $event)
    {
        $input = $event->widget;
        $fieldName = $this->getLocalFieldName($this->getInternalFieldName($input->getName()));
        $field = $this->getField($fieldName);

        if (!$field->hasTranslator()) {
            $this->markFieldValid($fieldName);
            return;
        }

        $translator = $field->getTranslator();

        try {
            if (!$field->getRequired() && ($input->getValue() === '' || $input->getValue() === null)) {
                $normalized = '';
            } else {
                $normalized = $translator->normalize($input->getValue());
            }
            $this->inputs[$fieldName]->setValue($normalized);
            $this->markFieldValid($fieldName);
        }

        catch (ValueTranslationException $e) {
            $this->markFieldInvalid($fieldName, $e->getMessage());
        }
    }

    public function handleFormSubmit(WidgetOnSubmitEvent $event)
    {
        $validFormData = $this->validateForm($event->getData());
    }

    final protected function validateForm(array $data) : array
    {
        $result = [
            'valid' => true,
            'errors' => [],
            'data' => [],
        ];

        foreach ($this->fields as $field) {
            if ($field instanceof ReplumForm) {

            }

            elseif ($field instanceof FieldDefinition) {
                if ($field->getRequired() && empty($data[$field->getName()])) {
                    $result['valid'] = false;
                    $result['errors'][$field->getName()] = 'Pflichtangabe, bitte ausfüllen.';
                    $this->markFieldInvalid($field->getName(), $result['errors'][$field->getName()]);
                }

                elseif (!$field->hasTranslator()) {
                    $result['data'][$field->getName()] = $data[$field->getName()];
                    $this->markFieldValid($field->getName());
                }

                else {
                    try {
                        $normalized = $field->getTranslator()->normalize($data[$field->getName()]);
                        $result['data'][$field->getName()] = $field->getTranslator()->import($normalized);
                        $this->markFieldValid($field->getName());
                    }

                    catch (ValueTranslationException $e) {
                        $result['valid'] = false;
                        $result['errors'][$field->getName()] = $e->getMessage();
                        $this->markFieldInvalid($field->getName(), $result['errors'][$field->getName()]);
                    }
                }
            }
        }

        return $result;
    }

    protected function markFieldValid(string $fieldName)
    {
        // Remove old error message
        if (isset($this->errorDivs[$fieldName]) && \count($this->errorDivs[$fieldName]->getChildren())) {
            foreach ($this->errorDivs[$fieldName]->getChildren() as $child) {
                $this->errorDivs[$fieldName]->del($child);
            }
            $this->formGroups[$fieldName]->setChanged(true);
        }

        $this->inputs[$fieldName]->delClass('is-invalid')->addClass('is-valid');
    }

    protected function markFieldInvalid(string $fieldName, string $errorMsg)
    {
        // Remove old error message
        if (isset($this->errorDivs[$fieldName]) && \count($this->errorDivs[$fieldName]->getChildren())) {
            foreach ($this->errorDivs[$fieldName]->getChildren() as $child) {
                $this->errorDivs[$fieldName]->del($child);
            }
            $this->formGroups[$fieldName]->setChanged(true);
        }

        $this->inputs[$fieldName]->delClass('is-valid')->addClass('is-invalid');

        if (!isset($this->errorDivs[$fieldName])) {
            $this->formGroups[$fieldName]->add(
                $this->errorDivs[$fieldName] = Html::div()
                    ->addClass('invalid-feedback')
            );
        }

        $this->errorDivs[$fieldName]->add(Html::text($errorMsg));
        $this->formGroups[$fieldName]->setChanged(true);
    }
}