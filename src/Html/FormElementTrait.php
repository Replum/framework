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
 */
trait FormElementTrait
{
    /**
     * @var Form
     */
    private $FormElementTraitForm;

    /**
     * @see FormElementInterface::getForm()
     */
    public function getForm() : Form
    {
        if ($this->FormElementTraitForm !== null) {
            return $this->FormElementTraitForm;
        }

        return $this->getNearestAncestor(Form::class);
    }

    /**
     * @see FormElementInterface::setForm()
     */
    public function setForm(Form $form) : FormElementInterface
    {
        $this->FormElementTraitForm = $form;
    }

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
    final public function setAutofocus(bool $autofocus) : FormElementInterface
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
    final public function setDisabled(bool $disabled) : FormElementInterface
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
     * @link http://www.w3.org/TR/html5/forms.html#attr-fe-name
     */
    final public function setName(string $name = null) : FormElementInterface
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
     * @link http://www.w3.org/TR/html5/forms.html#attr-input-value
     */
    final public function setValue(string $value = null) : FormElementInterface
    {
        if ($this->value !== $value) {
            $this->value = $value;
            $this->setChanged(true);
        }
        return $this;
    }

    final protected function renderFormElementAttributes() : string
    {
        return
            Util::renderHtmlAttribute('autofocus', $this->autofocus)
            . Util::renderHtmlAttribute('disabled', $this->disabled)
            . Util::renderHtmlAttribute('form', $this->FormElementTraitForm)
            . Util::renderHtmlAttribute('name', $this->name)
            . Util::renderHtmlAttribute('value', $this->value)
        ;
    }
}
