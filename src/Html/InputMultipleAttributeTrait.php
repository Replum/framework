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
 * @link https://www.w3.org/TR/html5/forms.html#attr-input-multiple
 */
trait InputMultipleAttributeTrait
{
    /**
     * @var bool
     * @link https://www.w3.org/TR/html5/forms.html#attr-input-multiple
     */
    private $multiple = false;

    /**
     * @link https://www.w3.org/TR/html5/forms.html#attr-input-multiple
     */
    final public function getMultiple() : bool
    {
        return $this->multiple;
    }

    /**
     * @return static $this
     * @link https://www.w3.org/TR/html5/forms.html#attr-input-multiple
     */
    final public function setMultiple(bool $multiple) : self
    {
        if ($this->multiple !== $multiple) {
            $this->multiple = $multiple;
            $this->setChanged(true);
        }

        return $this;
    }

    final protected function renderInputMultipleAttribute() : string
    {
        return \Replum\Util::renderHtmlAttribute('multiple', $this->multiple);
    }
}
