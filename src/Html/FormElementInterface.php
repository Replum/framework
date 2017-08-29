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

use \Replum\WidgetInterface;

/**
 * @author Dennis Birkholz <dennis@birkholz.org>
 */
interface FormElementInterface extends WidgetInterface
{
    /**
     * Get the form this FormElement is associated with
     */
    function getForm() : Form;

    /**
     * Set the form for the FormElement
     * Should only be used by handlers that manage form association,
     *
     * @return static $this
     */
    function setForm(Form $form) : self;

    /**
     * @link http://www.w3.org/TR/html5/forms.html#attr-fe-autofocus
     */
    function getAutofocus() : bool;

    /**
     * @return static $this
     * @link http://www.w3.org/TR/html5/forms.html#attr-fe-autofocus
     */
    function setAutofocus(bool $autofocus) : self;

    /**
     * @link http://www.w3.org/TR/html5/forms.html#attr-fe-disabled
     */
    function getDisabled() : bool;

    /**
     * @return static $this
     * @link http://www.w3.org/TR/html5/forms.html#attr-fe-disabled
     */
    function setDisabled(bool $disabled) : self;

    /**
     * @link http://www.w3.org/TR/html5/forms.html#attr-fe-name
     */
    function getName() : string;

    /**
     * @link http://www.w3.org/TR/html5/forms.html#attr-fe-name
     */
    function hasName() : bool;

    /**
     * @return static $this
     * @link http://www.w3.org/TR/html5/forms.html#attr-fe-name
     */
    function setName(string $name = null) : self;

    /**
     * @link http://www.w3.org/TR/html5/forms.html#attr-input-value
     */
    function getValue() : string;

    /**
     * @link http://www.w3.org/TR/html5/forms.html#attr-input-value
     */
    function hasValue() : bool;

    /**
     * @return static $this
     * @link http://www.w3.org/TR/html5/forms.html#attr-input-value
     */
    function setValue(string $value = null) : self;
}
