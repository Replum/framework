<?php

/**
 * This file is part of Replum: the web widget framework.
 *
 * Copyright (c) Dennis Birkholz <dennis@birkholz.org>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Replum\Html;

use \Replum\Util;

trait MinlengthMaxLengthAttributesTrait
{
    /**
     * Maximum length of value
     *
     * @var int
     */
    private $maxlength;

    /**
     * Get the maximum length of value
     *
     * @link https://www.w3.org/TR/html5/forms.html#attr-input-maxlength
     * @link https://www.w3.org/TR/html5/forms.html#attr-textarea-maxlength
     */
    final public function getMaxlength() : int
    {
        return $this->maxlength;
    }

    /**
     * Check whether the maximum length of value is set
     *
     * @link https://www.w3.org/TR/html5/forms.html#attr-input-maxlength
     * @link https://www.w3.org/TR/html5/forms.html#attr-textarea-maxlength
     */
    final public function hasMaxlength() : bool
    {
        return ($this->maxlength !== null);
    }

    /**
     * Set the maximum length of value
     *
     * @return static $this
     * @link https://www.w3.org/TR/html5/forms.html#attr-input-maxlength
     * @link https://www.w3.org/TR/html5/forms.html#attr-textarea-maxlength
     */
    final public function setMaxlength(int $maxlength = null) : self
    {
        if ($maxlength !== null && $this->maxlength !== null && $this->maxlength < $maxlength) {
            throw new \InvalidArgumentException('Maximum length must be less or equal to the maximum length (' . $this->maxlength . ')');
        }

        if ($this->maxlength !== $maxlength) {
            $this->maxlength = $maxlength;
            $this->setChanged(true);
        }
        return $this;
    }

    /**
     * Minimum length of value
     *
     * @var int
     */
    private $minlength;

    /**
     * Get the minimum length of value
     *
     * @link https://www.w3.org/TR/html5/forms.html#attr-input-minlength
     * @link https://www.w3.org/TR/html5/forms.html#attr-textarea-minlength
     */
    final public function getMinlength() : int
    {
        return $this->minlength;
    }

    /**
     * Check whether the minimum length of value is set
     *
     * @link https://www.w3.org/TR/html5/forms.html#attr-input-minlength
     * @link https://www.w3.org/TR/html5/forms.html#attr-textarea-minlength
     */
    final public function hasMinlength() : bool
    {
        return ($this->minlength !== null);
    }

    /**
     * Set the minimum length of value
     *
     * @return static $this
     * @link https://www.w3.org/TR/html5/forms.html#attr-input-minlength
     * @link https://www.w3.org/TR/html5/forms.html#attr-textarea-minlength
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

    final protected function renderMinlengthMaxlengthAttributes() : string
    {
        return
            Util::renderHtmlAttribute('minlength', $this->minlength)
            . Util::renderHtmlAttribute('maxlength', $this->maxlength)
        ;
    }
}
