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
 * @link https://www.w3.org/TR/html5/forms.html#attr-input-required
 */
trait RequiredAttributeTrait
{
    /**
     * @var boolean
     * @link https://www.w3.org/TR/html5/forms.html#attr-input-required
     */
    private $required = false;

    /**
     * @link https://www.w3.org/TR/html5/forms.html#attr-input-required
     */
    final public function getRequired() : bool
    {
        return $this->required;
    }

    /**
     * @return static $this
     * @link https://www.w3.org/TR/html5/forms.html#attr-input-required
     */
    final public function setRequired(bool $required) : self
    {
        if ($this->required !== $required) {
            $this->required = $required;
            $this->setChanged(true);
        }
        return $this;
    }

    final protected function renderRequiredAttribute() : string
    {
        return Util::renderHtmlAttribute('required', $this->required);
    }
}
