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

/**
 * @link https://www.w3.org/TR/html5/forms.html#attr-input-maxlength
 */
trait PatternAttributeTrait
{
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

    final protected function renderPatternAttribute() : string
    {
        return Util::renderHtmlAttribute('pattern', $this->pattern);
    }
}
