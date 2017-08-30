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

use \Replum\Util;

/**
 * @author Dennis Birkholz <dennis@birkholz.org>
 * @link https://www.w3.org/TR/html5/forms.html#the-option-element
 */
final class Option extends HtmlElement
{
    const TAG = 'option';
    const EMPTY_ELEMENT = true;

    ######################################################################
    # disabled attribute                                                 #
    ######################################################################

    /**
     * @var bool
     * @link https://www.w3.org/TR/html5/forms.html#attr-option-disabled
     */
    private $disabled = false;

    /**
     * @link https://www.w3.org/TR/html5/forms.html#attr-option-disabled
     */
    final public function getDisabled() : bool
    {
        return $this->disabled;
    }

    /**
     * @link https://www.w3.org/TR/html5/forms.html#attr-option-disabled
     */
    final public function setDisabled(bool $disabled) : self
    {
        if ($this->disabled !== $disabled) {
            $this->disabled = $disabled;
            $this->setChanged(true);
        }

        return $this;
    }

    ######################################################################
    # label attribute                                                    #
    ######################################################################

    /**
     * The text value to show for this element
     *
     * @var string
     * @link https://www.w3.org/TR/html5/forms.html#attr-option-label
     */
    private $label;

    /**
     * @link https://www.w3.org/TR/html5/forms.html#attr-option-label
     */
    final public function getLabel() : string
    {
        return $this->label;
    }

    /**
     * @link https://www.w3.org/TR/html5/forms.html#attr-option-label
     */
    final public function hasLabel() : bool
    {
        return ($this->label !== null);
    }

    /**
     * @return $this
     * @link https://www.w3.org/TR/html5/forms.html#attr-option-label
     */
    final public function setLabel(string $newLabel = null) : self
    {
        if ($this->label !== $newLabel) {
            $this->label = $newLabel;
            $this->setChanged(true);
        }

        return $this;
    }

    ######################################################################
    # selected attribute                                                 #
    ######################################################################

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
        return $this->selected !== null;
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

    ######################################################################
    # value attribute                                                    #
    ######################################################################

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

    ######################################################################
    # rendering                                                          #
    ######################################################################

    protected function renderAttributes() : string
    {
        return parent::renderAttributes()
            . Util::renderHtmlAttribute('disabled', $this->disabled)
            . Util::renderHtmlAttribute('label', $this->label)
            . Util::renderHtmlAttribute('selected', $this->selected)
            . Util::renderHtmlAttribute('value', $this->value)
        ;
    }

    public function render(): string
    {
        return '<' . self::TAG . $this->renderAttributes() . '>'
            . Util::escapeHtml($this->label !== null ? $this->label : $this->value)
            . '</' . self::TAG . '>' . PHP_EOL;
    }
}
