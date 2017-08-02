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

/**
 * @author Dennis Birkholz <dennis@birkholz.org>
 * @property boolean $disabled Enable/disable status of the form element
 * @property string $name Name of this button
 * @property string $type Type of the input
 * @property string $value Value to submit if this button is used to submit the formular
 */
trait FormInputTrait
{
    use FormElementTrait;

    /**
     * @var boolean
     * @link http://www.w3.org/TR/html5/forms.html#attr-fe-autocomplete
     */
    private $autocomplete;

    /**
     * @return boolean
     * @link http://www.w3.org/TR/html5/forms.html#attr-fe-autocomplete
     */
    protected function hasAutocomplete()
    {
        return $this->autocomplete;
    }

    /**
     * @return \Replum\Html\Input $this for chaining
     * @link http://www.w3.org/TR/html5/forms.html#attr-fe-autocomplete
     */
    protected function enableAutocomplete()
    {
        if ($this->autocomplete !== true) {
            $this->autocomplete = true;
            $this->setChanged();
        }
        return $this;
    }

    /**
     * @return \Replum\Html\Input $this for chaining
     * @link http://www.w3.org/TR/html5/forms.html#attr-fe-autocomplete
     */
    protected function disableAutocomplete()
    {
        if ($this->autocomplete !== false) {
            $this->autocomplete = false;
            $this->setChanged();
        }
        return $this;
    }

    /**
     * @return \Replum\Html\Input $this for chaining
     * @link http://www.w3.org/TR/html5/forms.html#attr-fe-autocomplete
     */
    protected function unsetAutocomplete()
    {
        if ($this->autocomplete !== null) {
            $this->autocomplete = null;
            $this->setChanged();
        }
        return $this;
    }

    /**
     * @return string
     */
    protected function renderAutocompleteAttribute()
    {
        return (!\is_null($this->autocomplete) ? ' autocomplete="' . ($this->autocomplete ? 'on' : 'off') . '"' : '');
    }

    /**
     * @var boolean
     * @link http://www.w3.org/TR/html5/forms.html#attr-fe-autofocus
     */
    private $autofocus;

    /**
     * @return boolean
     * @link http://www.w3.org/TR/html5/forms.html#attr-fe-autofocus
     */
    protected function hasAutofocus()
    {
        return $this->autofocus;
    }

    /**
     * @return \Replum\Html\Input $this for chaining
     * @link http://www.w3.org/TR/html5/forms.html#attr-fe-autofocus
     */
    protected function enableAutofocus()
    {
        if ($this->autofocus !== true) {
            $this->autofocus = true;
            $this->setChanged();
        }
        return $this;
    }

    /**
     * @return \Replum\Html\Input $this for chaining
     * @link http://www.w3.org/TR/html5/forms.html#attr-fe-autofocus
     */
    protected function disableAutofocus()
    {
        if ($this->autofocus !== false) {
            $this->autofocus = false;
            $this->setChanged();
        }
        return $this;
    }

    /**
     * @return string
     */
    protected function renderAutofocusAttribute()
    {
        return ($this->autofocus ? ' autofocus="autofocus"' : '');
    }

    /**
     * @var boolean
     * @link http://www.w3.org/TR/html5/forms.html#attr-input-checked
     */
    private $checked = false;

    /**
     * @return boolean
     * @link http://www.w3.org/TR/html5/forms.html#attr-input-checked
     */
    protected function isChecked()
    {
        return $this->checked;
    }

    /**
     * @return \Replum\Html\Input $this for chaining
     * @link http://www.w3.org/TR/html5/forms.html#attr-input-checked
     */
    protected function enableChecked()
    {
        return $this->setChecked(true);
    }

    /**
     * @return \Replum\Html\Input $this for chaining
     * @link http://www.w3.org/TR/html5/forms.html#attr-input-checked
     */
    protected function disableChecked()
    {
        return $this->setChecked(false);
    }

    protected function setChecked($newChecked)
    {
        if ($newChecked === 'true') { $newChecked = true; } elseif ($newChecked === 'false') { $newChecked = false; }

        if (!is_bool($newChecked)) {
            throw new \InvalidArgumentException('Invalid value "' . var_export($newChecked, true) . '", checked must be boolean.');
        }

        if ($this->checked != $newChecked) {
            $this->checked = (bool) $newChecked;
            $this->setChanged(true);
        }

        return $this;
    }

    /**
     * @return string
     */
    protected function renderCheckedAttribute()
    {
        return ($this->checked ? ' checked="checked"' : '');
    }

    /**
     * @var boolean
     * @link http://www.w3.org/TR/html5/forms.html#attr-fe-disabled
     */
    private $disabled = false;

    /**
     * @return boolean
     * @link http://www.w3.org/TR/html5/forms.html#attr-fe-disabled
     */
    public function isEnabled()
    {
        return !$this->disabled;
    }

    /**
     * @return boolean
     * @link http://www.w3.org/TR/html5/forms.html#attr-fe-disabled
     */
    public function isDisabled()
    {
        return $this->disabled;
    }

    /**
     * @return \Replum\Html\Input $this for chaining
     * @link http://www.w3.org/TR/html5/forms.html#attr-fe-disabled
     */
    public function enable()
    {
        if ($this->disabled !== false) {
            $this->disabled = false;
            $this->setChanged();
        }
        return $this;
    }

    /**
     * @return \Replum\Html\Input $this for chaining
     * @link http://www.w3.org/TR/html5/forms.html#attr-fe-disabled
     */
    public function disable()
    {
        if ($this->disabled !== true) {
            $this->disabled = true;
            $this->setChanged();
        }
        return $this;
    }

    /**
     * @return string
     */
    protected function renderDisabledAttribute()
    {
        return ($this->disabled ? ' disabled="disabled"' : '');
    }

    /**
     * @var int
     * @link http://www.w3.org/TR/html5/forms.html#attr-input-minlength
     */
    private $minlength;

    /**
     * @return int
     * @link http://www.w3.org/TR/html5/forms.html#attr-input-minlength
     */
    protected function getMinlength()
    {
        return $this->minlength;
    }

    /**
     * @param int $newMinlength
     * @return \Replum\Html\Input $this for chaining
     * @link http://www.w3.org/TR/html5/forms.html#attr-input-minlength
     */
    protected function setMinlength($newMinlength)
    {
        if (!\is_int($newMinlength) || ($newMinlength < 0)) {
            throw new \InvalidArgumentException('Minimum length must be an integer value >= 0');
        }

        if (!\is_null($this->maxlength) && ($this->maxlength < $newMinlength)) {
            throw new \InvalidArgumentException('Minimum length must be less or equal to the maximum length (' . $this->maxlength . ')');
        }

        if ($this->minlength !== $newMinlength) {
            $this->minlength = (int) $newMinlength;
            $this->setChanged();
        }
        return $this;
    }

    /**
     * Helper function to render the the name attribute
     * @return string
     */
    protected function renderMinlengthAttribute()
    {
        return (!\is_null($this->minlength) ? ' minlength="' . $this->escape($this->minlength) . '"' : '');
    }

    /**
     * @var int
     * @link http://www.w3.org/TR/html5/forms.html#attr-input-maxlength
     */
    private $maxlength;

    /**
     * @return int
     * @link http://www.w3.org/TR/html5/forms.html#attr-input-maxlength
     */
    protected function getMaxlength()
    {
        return $this->maxlength;
    }

    /**
     * @param int $newMaxlength
     * @return \Replum\Html\Input $this for chaining
     * @link http://www.w3.org/TR/html5/forms.html#attr-input-maxlength
     */
    protected function setMaxlength($newMaxlength)
    {
        if (!\is_int($newMaxlength) || ($newMaxlength < 0)) {
            throw new \InvalidArgumentException('Maximum length must be an integer value >= 0');
        }

        if (!\is_null($this->minlength) && ($newMaxlength < $this->minlength)) {
            throw new \InvalidArgumentException('Maximum length must be greater or equal to the minimum length (' . $this->minlength . ')');
        }

        if ($this->maxlength !== $newMaxlength) {
            $this->maxlength = (int) $newMaxlength;
            $this->setChanged();
        }
        return $this;
    }

    /**
     * Helper function to render the the name attribute
     * @return string
     */
    protected function renderMaxlengthAttribute()
    {
        return (!\is_null($this->maxlength) ? ' maxlength="' . $this->escape($this->maxlength) . '"' : '');
    }

    /**
     * @var boolean
     * @link http://www.w3.org/TR/html5/forms.html#attr-input-multiple
     */
    private $multiple = false;

    /**
     * @return boolean
     * @link http://www.w3.org/TR/html5/forms.html#attr-input-multiple
     */
    protected function isMultiple()
    {
        return $this->multiple;
    }

    /**
     * @return \Replum\Html\Input $this for chaining
     * @link http://www.w3.org/TR/html5/forms.html#attr-input-multiple
     */
    protected function enableMultiple()
    {
        if ($this->multiple !== true) {
            $this->multiple = true;
            $this->setChanged();
        }
        return $this;
    }

    /**
     * @return \Replum\Html\Input $this for chaining
     * @link http://www.w3.org/TR/html5/forms.html#attr-input-multiple
     */
    protected function disableMultiple()
    {
        if ($this->multiple !== false) {
            $this->multiple = false;
            $this->setChanged();
        }
        return $this;
    }

    /**
     * @return string
     */
    protected function renderMultipleAttribute()
    {
        return ($this->multiple ? ' multiple="multiple"' : '');
    }

    /**
     * @var string
     * @link http://www.w3.org/TR/html5/forms.html#attr-fe-name
     */
    private $name;

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
        if ($this->name !== $newName) {
            $this->name = $newName;
            $this->setChanged();
        }
        return $this;
    }

    /**
     * Helper function to render the the name attribute
     * @return string
     */
    protected function renderNameAttribute()
    {
        return (\is_null($this->name) ? '' : ' name="' . $this->escape($this->name) . '"');
    }

    /**
     * @var string
     * @link http://www.w3.org/TR/html5/forms.html#attr-input-placeholder
     */
    private $placeholder;

    /**
     * @return string
     * @link http://www.w3.org/TR/html5/forms.html#attr-input-placeholder
     */
    protected function getPlaceholder()
    {
        return $this->placeholder;
    }

    /**
     * @param string $newPlaceholder
     * @return \Replum\Html\Input $this for chaining
     * @link http://www.w3.org/TR/html5/forms.html#attr-input-placeholder
     */
    protected function setPlaceholder($newPlaceholder)
    {
        if ($this->placeholder !== $newPlaceholder) {
            $this->placeholder = $newPlaceholder;
            $this->setChanged();
        }
        return $this;
    }

    /**
     * Helper function to render the the name attribute
     * @return string
     */
    protected function renderPlaceholderAttribute()
    {
        return (\is_null($this->placeholder) ? '' : ' placeholder="' . $this->escape($this->placeholder) . '"');
    }

    /**
     * @var boolean
     * @link http://www.w3.org/TR/html5/forms.html#attr-input-readonly
     */
    private $readonly = false;

    /**
     * @return boolean
     * @link http://www.w3.org/TR/html5/forms.html#attr-input-readonly
     */
    protected function isReadonly()
    {
        return $this->readonly;
    }

    /**
     * @return \Replum\Html\Input $this for chaining
     * @link http://www.w3.org/TR/html5/forms.html#attr-input-readonly
     */
    protected function enableReadonly()
    {
        if ($this->readonly !== true) {
            $this->readonly = true;
            $this->setChanged();
        }
        return $this;
    }

    /**
     * @return \Replum\Html\Input $this for chaining
     * @link http://www.w3.org/TR/html5/forms.html#attr-input-readonly
     */
    protected function disableReadonly()
    {
        if ($this->readonly !== false) {
            $this->readonly = false;
            $this->setChanged();
        }
        return $this;
    }

    /**
     * @return string
     */
    protected function renderReadonlyAttribute()
    {
        return ($this->readonly ? ' readonly="readonly"' : '');
    }

    /**
     * @var boolean
     * @link http://www.w3.org/TR/html5/forms.html#attr-input-required
     */
    private $required = false;

    /**
     * @return boolean
     * @link http://www.w3.org/TR/html5/forms.html#attr-input-required
     */
    protected function isRequired()
    {
        return $this->required;
    }

    /**
     * @return \Replum\Html\Input $this for chaining
     * @link http://www.w3.org/TR/html5/forms.html#attr-input-required
     */
    protected function enableRequired()
    {
        if ($this->required !== true) {
            $this->required = true;
            $this->setChanged();
        }
        return $this;
    }

    /**
     * @return \Replum\Html\Input $this for chaining
     * @link http://www.w3.org/TR/html5/forms.html#attr-input-required
     */
    protected function disableRequired()
    {
        if ($this->required !== false) {
            $this->required = false;
            $this->setChanged();
        }
        return $this;
    }

    /**
     * @return string
     */
    protected function renderRequiredAttribute()
    {
        return ($this->required ? ' required="required"' : '');
    }

    /**
     * @var string
     * @link http://www.w3.org/TR/html5/forms.html#attr-input-type
     */
    private $type;

    /**
     * @return string
     * @link http://www.w3.org/TR/html5/forms.html#attr-input-type
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param string $newType
     * @return Input $this for chaining
     * @link http://www.w3.org/TR/html5/forms.html#attr-input-type
     */
    protected function setType($newType)
    {
        $types = $this->validTypes();
        $type = \strtolower($newType);

        if (!\in_array($type, $types)) {
            throw new \InvalidArgumentException('Invalid form element type "' . $newType . '", valid types are: "' . \implode('", "', $types) . '"');
        }

        if ($this->type !== $type) {
            $this->type = $type;
            $this->setChanged();
        }

        return $this;
    }

    /**
     * Override in implementations to further restrict possible types
     * @return array<string>
     */
    protected function validTypes()
    {
        return ['hidden', 'text', 'search', 'tel', 'url', 'email', 'password', 'date', 'time', 'number', 'range', 'color', 'checkbox', 'radio', 'file', 'submit', 'image', 'reset', 'button',];
    }

    /**
     * @return string
     */
    protected function renderTypeAttribute()
    {
        return (!\is_null($this->type) ? ' type="' . $this->escape($this->type) . '"' : '');
    }

    /**
     * @var string
     * @link http://www.w3.org/TR/html5/forms.html#attr-input-value
     */
    private $value;

    /**
     * @param string $newValue
     * @return \Replum\Html\TextInput $this for chaining
     * @link http://www.w3.org/TR/html5/forms.html#attr-input-value
     */
    public function setValue($newValue)
    {
        $this->value = $newValue;
        return $this;
    }

    /**
     * @return string
     * @link http://www.w3.org/TR/html5/forms.html#attr-input-value
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @return string
     */
    protected function renderValueAttribute()
    {
        return (\is_null($this->value) ? '' : ' value="' . $this->escape($this->value) . '"');
    }

    /**
     * Render all form attributes
     * @return string
     */
    protected function renderFormInputAttributes()
    {
        return $this->renderAutocompleteAttribute()
        . $this->renderAutofocusAttribute()
        . $this->renderCheckedAttribute()
        . $this->renderDisabledAttribute()
        . $this->renderMaxlengthAttribute()
        . $this->renderMinlengthAttribute()
        . $this->renderMultipleAttribute()
        . $this->renderNameAttribute()
        . $this->renderPlaceholderAttribute()
        . $this->renderReadonlyAttribute()
        . $this->renderRequiredAttribute()
        . $this->renderTypeAttribute()
        . $this->renderValueAttribute();
    }
}
