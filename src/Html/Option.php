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
use \Replum\Util;

/**
 * @author Dennis Birkholz <dennis@birkholz.org>
 * @property string  $label    User-visible label
 * @property string  $value    Value to be used for form submission
 * @property boolean $selected Whether the option is selected by default
 * @link http://www.w3.org/TR/html5/forms.html#the-option-element
 */
class Option extends HtmlElement
{
    /**
     * The text value to show for this element
     *
     * @var string
     * @link http://www.w3.org/TR/html5/forms.html#attr-option-label
     */
    protected $label;

    /**
     * @link http://www.w3.org/TR/html5/forms.html#attr-option-label
     */
    final public function getLabel() : string
    {
        return $this->label;
    }

    /**
     * @link http://www.w3.org/TR/html5/forms.html#attr-option-label
     */
    final public function hasLabel() : bool
    {
        return $this->label !== null;
    }

    /**
     * @return $this
     * @link http://www.w3.org/TR/html5/forms.html#attr-option-label
     */
    final public function setLabel(string $newLabel = null) : self
    {
        if ($this->label !== $newLabel) {
            $this->label = $newLabel;
            $this->setChanged(true);
        }

        return $this;
    }

    /**
     * The value to submit if this element is selected
     *
     * @var string
     * @link http://www.w3.org/TR/html5/forms.html#attr-option-value
     */
    protected $value;

    /**
     * @link http://www.w3.org/TR/html5/forms.html#attr-option-value
     */
    final public function getValue() : string
    {
        return $this->value;
    }

    /**
     * @link http://www.w3.org/TR/html5/forms.html#attr-option-value
     */
    final public function hasValue() : bool
    {
        return ($this->value !== null);
    }

    /**
     * @return $this
     * @link http://www.w3.org/TR/html5/forms.html#attr-option-value
     */
    final public function setValue(string $newValue) : self
    {
        if ($this->value !== $newValue) {
            $this->value = $newValue;
            $this->setChanged(true);
        }

        return $this;
    }

    /**
     * @var boolean
     * @link http://www.w3.org/TR/html5/forms.html#attr-option-selected
     */
    protected $selected;

    /**
     * @link http://www.w3.org/TR/html5/forms.html#attr-option-selected
     */
    final public function getSelected() : bool
    {
        return $this->selected;
    }

    /**
     * @link http://www.w3.org/TR/html5/forms.html#attr-option-selected
     */
    final public function hasSelected() : bool
    {
        return $this->selecte !== null;
    }

    /**
     * @return $this
     * @link http://www.w3.org/TR/html5/forms.html#attr-option-selected
     */
    final public function setSelected(bool $newSelected = null) : self
    {
        if ($this->selected !== $newSelected) {
            $this->selected = $newSelected;
            $this->setChanged(true);
        }

        return $this;
    }

    protected function renderAttributes() : string
    {
        return parent::renderAttributes()
        . Util::renderHtmlAttribute('value', $this->value)
        . Util::renderHtmlAttribute('selected', ($this->selected ? 'selected' : null))
        ;
    }

    public function render() : string
    {
        return '<option' . $this->renderAttributes() . '>' . Util::escapeHtml($this->label) . '</option>';
    }

    public static function create(PageInterface $page) : self
    {
        return new self($page);
    }
}
