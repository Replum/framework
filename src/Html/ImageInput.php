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
 * @author Dennis Birkholz <dennis@birkholz.org>
 */
final class ImageInput extends Input
{
    const TYPE = 'image';

    /**
     * @var string
     * @link https://www.w3.org/TR/html5/forms.html#attr-input-alt
     */
    private $alt;

    /**
     * @link https://www.w3.org/TR/html5/forms.html#attr-input-alt
     */
    final public function getAlt() : string
    {
        return $this->alt;
    }

    /**
     * @return boolean
     * @link https://www.w3.org/TR/html5/forms.html#attr-input-alt
     */
    final public function hasAlt() : bool
    {
        return ($this->alt !== null);
    }

    /**
     * @link https://www.w3.org/TR/html5/forms.html#attr-input-alt
     */
    final public function setAlt(string $alt = null) : self
    {
        if ($this->alt !== $alt) {
            $this->alt = $alt;
            $this->setChanged(true);
        }

        return $this;
    }

    protected function renderAttributes() : string#
    {
        return parent::renderAttributes()
            . Util::renderHtmlAttribute('alt', $this->alt)
        ;
    }
}
