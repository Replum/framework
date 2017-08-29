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
 * @todo: implement dirname attribute
 */
abstract class Input extends HtmlElement implements FormInputInterface
{
    use FormElementTrait;

    const AUTOCOMPLETE_ON = 'on';
    const AUTOCOMPLETE_OFF = 'off';

    /**
     * @var bool
     * @link http://www.w3.org/TR/html5/forms.html#attr-fe-autofocus
     */
    private $autofocus = false;

    /**
     * @link http://www.w3.org/TR/html5/forms.html#attr-fe-autofocus
     */
    final public function getAutofocus() : bool
    {
        return $this->autofocus;
    }

    /**
     * @link http://www.w3.org/TR/html5/forms.html#attr-fe-autofocus
     */
    final public function setAutofocus(bool $autofocus) : self
    {
        if ($this->autofocus !== $autofocus) {
            $this->autofocus = $autofocus;
            $this->setChanged(true);
        }

        return $this;
    }

    /**
     * @var bool
     * @link http://www.w3.org/TR/html5/forms.html#attr-fe-disabled
     */
    private $disabled = false;

    /**
     * @link http://www.w3.org/TR/html5/forms.html#attr-fe-disabled
     */
    final public function getDisabled() : bool
    {
        return $this->disabled;
    }

    /**
     * @link http://www.w3.org/TR/html5/forms.html#attr-fe-disabled
     */
    final public function setDisabled(bool $disabled) : self
    {
        if ($this->disabled !== $disabled) {
            $this->disabled = $disabled;
            $this->setChanged(true);
        }

        return $this;
    }

    /**
     * @var string
     * @link http://www.w3.org/TR/html5/forms.html#attr-fe-name
     */
    private $name;

    /**
     * @link http://www.w3.org/TR/html5/forms.html#attr-fe-name
     */
    final public function getName() : string
    {
        return $this->name;
    }

    /**
     * @link http://www.w3.org/TR/html5/forms.html#attr-fe-name
     */
    final public function hasName() : bool
    {
        return ($this->name !== null);
    }

    /**
     * @return $this
     * @link http://www.w3.org/TR/html5/forms.html#attr-fe-name
     */
    final public function setName(string $name = null) : self
    {
        if ($this->name !== $name) {
            $this->name = $name;
            $this->setChanged(true);
        }
        return $this;
    }

    /**
     * @var string
     * @link http://www.w3.org/TR/html5/forms.html#attr-input-value
     */
    private $value;

    /**
     * @link http://www.w3.org/TR/html5/forms.html#attr-input-value
     */
    final public function getValue() : string
    {
        return $this->value;
    }

    /**
     * @link http://www.w3.org/TR/html5/forms.html#attr-input-value
     */
    final public function hasValue() : bool
    {
        return ($this->value !== null);
    }

    /**
     * @return $this
     * @link http://www.w3.org/TR/html5/forms.html#attr-input-value
     */
    final public function setValue(string $value = null) : self
    {
        if ($this->value !== $value) {
            $this->value = $value;
            $this->setChecked(true);
        }
        return $this;
    }

    protected function renderAttributes() : string
    {
        return parent::renderAttributes()
            . Util::renderHtmlAttribute('autofocus', $this->autofocus)
            . Util::renderHtmlAttribute('disabled', $this->disabled)
            . Util::renderHtmlAttribute('name', $this->name)
            . Util::renderHtmlAttribute('type', static::TYPE)
            . Util::renderHtmlAttribute('value', $this->value)
        ;
    }
}
