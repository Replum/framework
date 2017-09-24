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
use Replum\Html\Form;
use Replum\Html\FormInputInterface;
use Replum\Html\HtmlElement;
use Replum\HtmlFactory as Html;

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

    protected function getFields() : array
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

        $formGroup = $this->formGroups[$fieldName] = Html::div();
        $formGroup
            ->needID()
            ->addClass('form-group')
        ;

        if ($field->hasValues()) {
            $input = $this->inputs[$fieldName] = Html::select();
            $input
                ->needID()
                ->setName($this->getRealFieldName($fieldName))
                ->addClass('form-control')
                ->addClass('boxed')
                ->onChange([$this, 'handleFormChange'])
            ;

            $input->setValues($field->getValues());
        }

        else {
            $input = $this->inputs[$fieldName] = Html::textInput();
            $input
                ->needID()
                ->setName($this->getRealFieldName($fieldName))
                ->addClass('form-control')
                ->addClass('boxed')
                ->onChange([$this, 'handleFormChange'])
            ;

            if ($field->hasPlaceholder()) {
                $input->setPlaceHolder($field->getPlaceholder());
            }
        }

        if ($field->hasDefaultValue()) {
            $input->setValue($field->getDefaultValue());
        }

        if ($field->hasLabel()) {
            $label = $this->labels[$fieldName] = Html::label();
            $label
                ->add(Html::text($field->getLabel()))
                ->setFor($input)
            ;
            $formGroup->add($label);
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
        /* @var $input FormInputInterface */
        $input = $event->widget;
        $fieldName = $this->getLocalFieldName($this->getInternalFieldName($input->getName()));
        $field = $this->getField($fieldName);

        if ($field->getRequired() && empty($input->getValue())) {
            $this->markFieldInvalid($field->getName(), 'Pflichtangabe, bitte ausfüllen.');
        }

        elseif (!$field->hasTranslator()) {
            $this->markFieldValid($field->getName());
        }

        else {
            try {
                if (!empty($input->getValue())) {
                    $normalized = $field->getTranslator()->normalize($input->getValue());
                    $input->setValue($normalized);
                }
                $this->markFieldValid($field->getName());
            }

            catch (ValueTranslationException $e) {
                $this->markFieldInvalid($field->getName(), $e->getMessage());
            }
        }
    }

    /**
     * @var callable
     */
    private $formValidHandler;

    /**
     * @return static $this
     */
    final public function onFormValid(callable $handler) : self
    {
        $this->formValidHandler = $handler;
        return $this;
    }

    public function handleFormSubmit(WidgetOnSubmitEvent $event)
    {
        $formData = $this->validateForm($event->getData());
        if (!$formData['valid']) {
            //throw new \RuntimeException("Form is invalid: " . \print_r($formData['errors'], true));
            return;
        }

        try {
            if ($this->formValidHandler !== null && \is_callable($this->formValidHandler)) {
                $handler = $this->formValidHandler;
                $handler($formData);
            } else {
                throw new \RuntimeException('No valid handler!');
            }
        } catch (FieldValidationException $e) {
            if (isset($this->fields[$e->getField()])) {
                $this->markFieldInvalid($e->getField(), $e->getMessage());
            } else {
                throw new \RuntimeException('Form validation error', null, $e);
            }
        }
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
                $prefix = \explode('.', $field->getPrefix());
                $subInData = $data;
                $subErrors = &$result['errors'];
                $subOutData = &$result['data'];
                foreach ($prefix as $prefixElement) {
                    $subInData = $subInData[$prefixElement];
                    $subErrors = &$subErrors[$prefixElement];
                    $subOutData = &$subOutData[$prefixElement];
                }

                $subFormResult = $field->validateForm($subInData);
                foreach ($subFormResult['data'] as $key => $value) {
                    $subOutData[$key] = $value;
                }

                if (!$subFormResult['valid']) {
                    $result['valid'] = false;
                    foreach ($subFormResult['errors'] as $key => $value) {
                        $subErrors[$key] = $value;
                    }
                }
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
                        if (empty($data[$field->getName()])) {
                            $normalized = '';
                        } else {
                            $normalized = $field->getTranslator()->normalize($data[$field->getName()]);
                        }

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

    public function importData(array $values)
    {
        foreach ($this->getFields() as $field) {
            if ($field instanceof FieldDefinition) {
                // Nothing to import here
                if (!isset($values[$field->getName()])) { continue; }

                $value = $values[$field->getName()];
                if ($field->hasTranslator()) {
                    $imported = $field->getTranslator()->import($value);
                } else {
                    $imported = $value;
                }
                $field->setDefaultValue($imported);
            }
        }
    }
}