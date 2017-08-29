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
 * @link https://www.w3.org/TR/html5/forms.html#attr-input-maxlength
 * @link https://www.w3.org/TR/html5/forms.html#attr-input-minlength
 * @link https://www.w3.org/TR/html5/forms.html#attr-input-pattern
 * @link https://www.w3.org/TR/html5/forms.html#attr-input-size
 */
trait InputMinLengthMaxLengthPatternSizeAttributesTrait
{
    /**
     * @var int
     * @link https://www.w3.org/TR/html5/forms.html#attr-input-maxlength
     */
    private $maxlength;

    /**
     * @link https://www.w3.org/TR/html5/forms.html#attr-input-maxlength
     */
    final public function getMaxlength() : int
    {
        return $this->maxlength;
    }

    /**
     * @link https://www.w3.org/TR/html5/forms.html#attr-input-maxlength
     */
    final public function hasMaxlength() : bool
    {
        return ($this->maxlength !== null);
    }

    /**
     * @return static $this
     * @link https://www.w3.org/TR/html5/forms.html#attr-input-maxlength
     */
    final public function setMaxlength(int $maxlength = null) : self
    {
        if ($this->minlength !== null && $maxlength && $maxlength < $this->minlength) {
            throw new \InvalidArgumentException('Maximum length must be greater equal to the minimum length (' . $this->minlength . ')');
        }

        if ($this->maxlength !== $maxlength) {
            $this->maxlength = $maxlength;
            $this->setChanged(true);
        }
        return $this;
    }

    /**
     * @var int
     * @link https://www.w3.org/TR/html5/forms.html#attr-input-minlength
     */
    private $minlength;

    /**
     * @link https://www.w3.org/TR/html5/forms.html#attr-input-minlength
     */
    final public function getMinlength() : int
    {
        return $this->minlength;
    }

    /**
     * @link https://www.w3.org/TR/html5/forms.html#attr-input-minlength
     */
    final public function hasMinlength() : bool
    {
        return ($this->minlength !== null);
    }

    /**
     * @return static $this
     * @link https://www.w3.org/TR/html5/forms.html#attr-input-minlength
     */
    final public function setMinlength(int $minlength = null) : self
    {
        if ($minlength !== null && $this->maxlength !== null && $this->maxlength < $minlength) {
            throw new \InvalidArgumentException('Minimum length must be less or equal to the maximum length (' . $this->maxlength . ')');
        }

        if ($this->minlength !== $minlength) {
            $this->minlength = $minlength;
            $this->setChanged(true);
        }
        return $this;
    }

    /**
     * @var string
     * @link https://www.w3.org/TR/html5/forms.html#attr-input-pattern
     */
    private $pattern;

    /**
     * @link https://www.w3.org/TR/html5/forms.html#attr-input-pattern
     */
    final public function getPattern() : string
    {
        return $this->pattern;
    }

    /**
     * @link https://www.w3.org/TR/html5/forms.html#attr-input-pattern
     */
    final public function hasPattern() : bool
    {
        return ($this->pattern !== null);
    }

    /**
     * @return static $this
     * @link https://www.w3.org/TR/html5/forms.html#attr-input-pattern
     */
    final public function setPattern(string $pattern = null) : self
    {
        if ($this->pattern !== $pattern) {
            $this->pattern = $pattern;
            $this->setChanged(true);
        }
        return $this;
    }

    /**
     * @var int
     * @link https://www.w3.org/TR/html5/forms.html#attr-input-size
     */
    private $size;

    /**
     * @link https://www.w3.org/TR/html5/forms.html#attr-input-size
     */
    final public function getSize() : int
    {
        return $this->size;
    }

    /**
     * @link https://www.w3.org/TR/html5/forms.html#attr-input-size
     */
    final public function hasSize() : bool
    {
        return ($this->size !== null);
    }

    /**
     * @return static $this
     * @link https://www.w3.org/TR/html5/forms.html#attr-input-size
     */
    final public function setSize(int $size = null) : self
    {
        if ($this->size !== $size) {
            $this->size = $size;
            $this->setChanged(true);
        }
        return $this;
    }

    final protected function renderInputMinLengthMaxLengthPatternSizeAttributes() : string
    {
        return Util::renderHtmlAttribute('minlength', $this->minlength)
            . Util::renderHtmlAttribute('maxlength', $this->maxlength)
            . Util::renderHtmlAttribute('pattern', $this->pattern)
            . Util::renderHtmlAttribute('size', $this->size)
        ;
    }
}
