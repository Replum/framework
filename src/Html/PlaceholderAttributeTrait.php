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
 * @link https://www.w3.org/TR/html5/forms.html#attr-input-placeholder
 */
trait PlaceholderAttributeTrait
{
    /**
     * @var string
     * @link https://www.w3.org/TR/html5/forms.html#attr-input-placeholder
     */
    private $placeholder;

    /**
     * @link https://www.w3.org/TR/html5/forms.html#attr-input-placeholder
     */
    final public function getPlaceholder() : string
    {
        return $this->placeholder;
    }

    /**
     * @link https://www.w3.org/TR/html5/forms.html#attr-input-placeholder
     */
    final public function hasPlaceholder() : bool
    {
        return ($this->placeholder !== null);
    }

    /**
     * @return static $this
     * @link https://www.w3.org/TR/html5/forms.html#attr-input-placeholder
     */
    final public function setPlaceholder(string $placeholder = null) : self
    {
        if ($this->placeholder !== $placeholder) {
            $this->placeholder = $placeholder;
            $this->setChanged(true);
        }
        return $this;
    }

    final protected function renderPlaceholderAttribute() : string
    {
        return Util::renderHtmlAttribute('placeholder', $this->placeholder);
    }
}
