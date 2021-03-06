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
use \Replum\WidgetTrait;
use \Replum\WidgetHasChangeEventInterface;
use \Replum\WidgetHasChangeEventTrait;

/**
 * @author Dennis Birkholz <dennis@birkholz.biz>
 * @property string $name Name of the form element
 * @property string $value Value selected in the dropdown
 * @property array $possible List of possible values
 */
class DropDown implements FormInputInterface, WidgetHasChangeEventInterface
{
    use WidgetTrait,
        FormElementTrait,
        WidgetHasChangeEventTrait;

    /**
     * @var string
     */
    private $name;

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $newName
     * @return static $this for chaining
     */
    public function setName($newName)
    {
        if ($this->name != $newName) {
            $this->name = $newName;
            $this->setChanged();
        }
        return $this;
    }

    /**
     * The list of possible values for this dropdown
     *
     * @var array<string, string>
     */
    private $possible = [];

    /**
     * @return array<string, string>
     */
    public function getPossible()
    {
        return $this->possible;
    }

    /**
     * @param array<string, string> $newValues
     * @return static $this for chaining
     */
    public function setPossible(array $newValues)
    {
        if ($this->possible != $newValues) {
            $this->possible = $newValues;
            $this->setChanged();
        }
        return $this;
    }

    /**
     * Modify the existing list of values.
     * @return static $this for chaining
     */
    public function updatePossible(array $changeValues)
    {
        $this->possible = \array_merge($this->possible, $changeValues);
        $this->setChanged();
        return $this;
    }

    /**
     * @var string
     */
    private $value;

    /**
     * @return string
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @param string $newValue
     * @return static $this for chaining
     */
    public function setValue($newValue)
    {
        if (isset($this->possible[$newValue])) {
            // Keep value
        } elseif (false !== ($key = \array_search($newValue, $this->possible))) {
            $newValue = $key;
        } elseif (($newValue === null) || ($newValue === '')) {
            $newValue = null;
        } else {
            throw new \InvalidArgumentException('Invalid value "' . $newValue . '"');
        }

        if ($this->value != $newValue) {
            $this->value = $newValue;
            $this->setChanged();
        }
        return $this;
    }

    public function render()
    {
        $r = '<select ';
        $r .= Util::renderHtmlAttribute('name', $this->name);
        $r .= $this->renderAttributes();
        $r .= '>';

        foreach ($this->possible as $value => $display) {
            $r .= '<option ' . Util::renderHtmlAttribute('value', $this->value);
            if ($this->value == $value) { $r .= ' selected="selected"'; }
            $r .= '>' . Util::escapeHtml($display) . '</option>';
        }

        $r .= '</select>';

        return $r;
    }
}
