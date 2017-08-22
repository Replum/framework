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
     * @return string
     * @link http://www.w3.org/TR/html5/forms.html#attr-option-label
     */
    public function getLabel()
    {
        return $this->label;
    }

    /**
     * @param type $newLabel
     * @return static $this for chaining
     * @link http://www.w3.org/TR/html5/forms.html#attr-option-label
     */
    public function setLabel($newLabel)
    {
        return $this->setStringProperty('label', $newLabel);
    }

    /**
     * The value to submit if this element is selected
     *
     * @var string
     * @link http://www.w3.org/TR/html5/forms.html#attr-option-value
     */
    protected $value;

    /**
     * @return string
     * @link http://www.w3.org/TR/html5/forms.html#attr-option-value
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @param type $newValue
     * @return static $this for chaining
     * @link http://www.w3.org/TR/html5/forms.html#attr-option-value
     */
    public function setValue($newValue)
    {
        return $this->setStringProperty('value', $newValue);
    }

    /**
     * @var boolean
     * @link http://www.w3.org/TR/html5/forms.html#attr-option-selected
     */
    protected $selected;

    /**
     * @return boolean
     * @link http://www.w3.org/TR/html5/forms.html#attr-option-selected
     */
    public function getSelected()
    {
        return $this->selected;
    }

    /**
     * @param boolean $newSelected
     * @return static
     * @link http://www.w3.org/TR/html5/forms.html#attr-option-selected
     */
    public function setSelected($newSelected)
    {
        return $this->setBooleanProperty('selected', $newSelected);
    }

    protected function renderAttributes() : string
    {
        return parent::renderAttributes()
        . $this->renderHtmlAttribute('value', $this->value)
        . $this->renderHtmlAttribute('selected', ($this->selected ? 'selected' : null))
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
