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
use \Replum\WidgetInterface;
use \Replum\WidgetTrait;
use \Replum\WidgetHasChangeEventInterface;
use \Replum\WidgetHasChangeEventTrait;

/**
 * @author Dennis Birkholz <dennis@birkholz.org>
 */
class NumberInput implements FormInputInterface, WidgetHasChangeEventInterface
{
    use WidgetTrait,
        WidgetHasChangeEventTrait,
        FormInputTrait {
        hasAutocomplete as public;
        enableAutocomplete as public;
        disableAutocomplete as public;
        unsetAutocomplete as public;

        hasAutofocus as public;
        enableAutofocus as public;
        disableAutofocus as public;

        getPlaceholder as public;
        setPlaceholder as public;

        isReadonly as public;
        enableReadonly as public;
        disableReadonly as public;

        isRequired as public;
        enableRequired as public;
        disableRequired as public;

        setValue as private originalSetValue;
    }

    /**
     * @var integer
     */
    private $min;

    /**
     * @return integer
     */
    public function getMin()
    {
        return $this->min;
    }

    /**
     * @param integer $newMin
     * @return static $this for chaining
     */
    public function setMin($newMin)
    {
        if (!is_int($newMin) && !is_float($newMin)) {
            throw new \InvalidArgumentException('Minimum must be an integer or float number');
        }

        if ($this->min !== $newMin) {
            $this->min = $newMin;
            $this->setChanged();
        }

        return $this;
    }

    private function renderMin()
    {
        return Util::renderHtmlAttribute('min', $this->min);
    }

    /**
     * @var integer
     */
    private $max;

    /**
     * @return integer
     */
    public function getMax()
    {
        return $this->max;
    }

    /**
     * @param integer $newMax
     * @return static $this for chaining
     */
    public function setMax($newMax)
    {
        if (!is_int($newMax) && !is_float($newMax)) {
            throw new \InvalidArgumentException('Maximum must be an integer or float number');
        }

        if ($this->max !== $newMax) {
            $this->max = $newMax;
            $this->setChanged();
        }

        return $this;
    }

    private function renderMax()
    {
        return Util::renderHtmlAttribute('max', $this->max);
    }

    /**
     * @var float
     */
    private $step;

    /**
     * @return float
     */
    public function getStep()
    {
        return $this->step;
    }

    /**
     * @param float $newStep
     * @return static $this for chaining
     */
    public function setStep($newStep)
    {
        if (!is_int($newStep) && !is_float($newStep)) {
            throw new \InvalidArgumentException('Step must be an integer or float number');
        }

        if ($this->step !== $newStep) {
            $this->step = $newStep;
            $this->setChanged();
        }

        return $this;
    }

    public function setValue($newValue)
    {
        if (is_null($newValue) || ($newValue === '')) {
            return $this->originalSetValue(null);
        }

        if (!is_numeric($newValue)) {
            throw new \InvalidArgumentException('Invalid number 1');
        }

        if (!is_null($this->min) && ($newValue < $this->min)) {
            throw new \InvalidArgumentException('Invalid number 2');
        }

        if (!is_null($this->max) && ($this->max < $newValue)) {
            throw new \InvalidArgumentException('Invalid number 3');
        }

        if (!is_null($this->min) && !is_null($this->step) && is_int($this->step)) {
            $matchesStep = ($newValue - $this->min) % $this->step;

            if ($matchesStep) {
                throw new \InvalidArgumentException('Invalid number 4: ' . $matchesStep);
            }
        }

        return $this->originalSetValue($newValue);
    }

    /**
     * @param \Replum\WidgetInterface $parent
     * @param string $name
     */
    public function __construct(WidgetInterface $parent = null)
    {
        if (!is_null($parent)) { $this->setParent($parent); }
        $this->setType('number');
    }

    public function __toString()
    {
        return '<input'
        . $this->renderAttributes()
        . $this->renderFormInputAttributes()
        . $this->renderMin()
        . $this->renderMax()
        . ' />';
    }
}
