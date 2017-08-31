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

trait SizeAttributeTrait
{
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

    final protected function renderSizeAttribute() : string
    {
        return Util::renderHtmlAttribute('size', $this->size);
    }
}
