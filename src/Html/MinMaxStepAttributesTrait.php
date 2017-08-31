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
 * @link https://www.w3.org/TR/html5/forms.html#attr-input-min
 * @link https://www.w3.org/TR/html5/forms.html#attr-input-max
 * @link https://www.w3.org/TR/html5/forms.html#attr-input-step
 */
trait MinMaxStepAttributesTrait
{
    /**
     * @var float
     * @link https://www.w3.org/TR/html5/forms.html#attr-input-min
     */
    private $min;

    /**
     * @link https://www.w3.org/TR/html5/forms.html#attr-input-min
     */
    final public function getMin() : float
    {
        return $this->min;
    }

    /**
     * @link https://www.w3.org/TR/html5/forms.html#attr-input-min
     */
    final public function hasMin() : bool
    {
        return ($this->min !== null);
    }

    /**
     * @return static $this
     * @link https://www.w3.org/TR/html5/forms.html#attr-input-min
     */
    final public function setMin(float $min = null) : self
    {
        if ($min !== null && $this->max !== null && $this->max < $min) {
            throw new \InvalidArgumentException('Minimum must be less or equal to the maximum (' . $this->max . ')');
        }

        if ($this->min !== $min) {
            $this->min = $min;
            $this->setChanged(true);
        }
        return $this;
    }

    /**
     * @var float
     * @link https://www.w3.org/TR/html5/forms.html#attr-input-max
     */
    private $max;

    /**
     * @link https://www.w3.org/TR/html5/forms.html#attr-input-max
     */
    final public function getMax() : float
    {
        return $this->max;
    }

    /**
     * @link https://www.w3.org/TR/html5/forms.html#attr-input-max
     */
    final public function hasMax() : bool
    {
        return ($this->max !== null);
    }

    /**
     * @return static $this
     * @link https://www.w3.org/TR/html5/forms.html#attr-input-max
     */
    final public function setMax(float $max = null) : self
    {
        if ($this->min !== null && $max && $max < $this->min) {
            throw new \InvalidArgumentException('Maximum must be greater equal to the minimum (' . $this->min . ')');
        }

        if ($this->max !== $max) {
            $this->max = $max;
            $this->setChanged(true);
        }
        return $this;
    }

    /**
     * @var float
     * @link https://www.w3.org/TR/html5/forms.html#attr-input-step
     */
    private $step;

    /**
     * @link https://www.w3.org/TR/html5/forms.html#attr-input-step
     */
    final public function getStep() : float
    {
        return $this->step;
    }

    /**
     * @link https://www.w3.org/TR/html5/forms.html#attr-input-step
     */
    final public function hasStep() : bool
    {
        return ($this->step !== null);
    }

    /**
     * @return static $this
     * @link https://www.w3.org/TR/html5/forms.html#attr-input-step
     */
    final public function setStep(float $step = null) : self
    {
        if ($this->step !== $step) {
            $this->step = $step;
            $this->setChanged(true);
        }

        return $this;
    }

    final protected function renderMinMaxStepAttributes() : string
    {
        return Util::renderHtmlAttribute('min', $this->min)
            . Util::renderHtmlAttribute('max', $this->max)
            . Util::renderHtmlAttribute('step', $this->step)
        ;
    }
}
