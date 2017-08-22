<?php

/*
 * This file is part of Replum: the web widget framework.
 *
 * Copyright (c) Dennis Birkholz <dennis@birkholz.org>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Replum\Html;

use \Replum\PageInterface;
use \Replum\WidgetHasChangeEventInterface;
use \Replum\WidgetHasChangeEventTrait;

/**
 * @author Dennis Birkholz <dennis@birkholz.org>
 * @property string $name   Name this element is identified with in its form
 * @property array  $values The possible values in this select
 * @property string $value  The currently selected value
 */
class Select extends HtmlElement implements WidgetHasChangeEventInterface, FormInputInterface
{
    use WidgetHasChangeEventTrait,
        FormElementTrait;

    /**
     * @var string
     * @link http://www.w3.org/TR/html5/forms.html#attr-fe-name
     */
    protected $name;

    /**
     * @return string
     * @link http://www.w3.org/TR/html5/forms.html#attr-fe-name
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $newName
     * @return \Replum\Html\Input $this for chaining
     * @link http://www.w3.org/TR/html5/forms.html#attr-fe-name
     */
    public function setName($newName)
    {
        return $this->setStringProperty('name', $newName);
    }

    /**
     * @var array
     */
    protected $values;

    /**
     * @var boolean
     */
    protected $isAssoc;

    /**
     * @return array
     */
    public function getValues()
    {
        return $this->values;
    }

    /**
     * @param array $values
     * @param boolean $hasKeys $values contains separate values and labels
     * @return static $this for chaining
     */
    public function setValues($values, $hasKeys = true)
    {
        if (($this->values !== $values) && ($this->isAssoc !== $hasKeys)) {
            $this->values = $values;
            $this->isAssoc = (bool) $hasKeys;
            $this->setChanged(true);
        }
        return $this;
    }

    /**
     * @var string
     */
    protected $value;

    /**
     * @return string
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     *
     * @param type $newValue
     * @return \Replum\Html\Select
     */
    public function setValue($newValue)
    {
        return $this->setStringProperty('value', $newValue);
    }

    /**
     * @var int
     */
    protected $size;

    /**
     * @return int
     */
    public function getSize() {
        return $this->size;
    }

    /**
     * @param int $newSize
     * @return \Replum\Html\Select
     */
    public function setSize($newSize) {
        return $this->setPropertyValue('size', (int)$newSize);
    }

    protected function renderAttributes() : string
    {
        return parent::renderAttributes()
        . $this->renderHtmlAttribute('name', $this->name)
        . $this->renderHtmlAttribute('size', $this->size)
        ;
    }

    public function render() : string
    {
        try {
            //$this->children = [];
            $this->createOptions($this, $this->values);

            return '<select' . $this->renderAttributes() . '>'
            . $this->renderChildren()
            . '</select>'
            ;
        } catch (\Exception $e) {
            echo '<pre>' . $e;
            exit;
        }
    }

    protected function createOptions($parent, $values)
    {
        foreach ($values as $value => $label) {
            if (\is_array($label)) {
                $optgroup = OptionGroup::create($this->getPage(), 'label', $value);
                $parent->add($optgroup);
                $this->{__FUNCTION__}($optgroup, $label);
            }

            else {
                $option = Option::create($this->getPage())->setLabel($label)->setValue($this->isAssoc ? $value : $label);
                if (($this->value !== null) && ($value === $this->value)) {
                    $option->setSelected(true);
                }
                $parent->add($option);
            }
        }
    }

    public static function create(PageInterface $page) : self
    {
        return new self($page);
    }
}
