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
 * @link https://www.w3.org/TR/html5/forms.html#the-optgroup-element
 */
final class OptionGroup extends HtmlElement
{
    const TAG = 'optgroup';

    /**
     * User-visible label
     *
     * @var string
     * @link https://www.w3.org/TR/html5/forms.html#attr-optgroup-label
     */
    protected $label;

    /**
     * Check whether the user-visible label is set
     */
    public function getLabel() : string
    {
        return $this->label;
    }

    /**
     * @link http://www.w3.org/TR/html5/forms.html#attr-optgroup-label
     */
    public function hasLabel() : bool
    {
        return ($this->label !== null);
    }

    /**
     * Set or clear the user-visible label
     *
     * @return static $this
     * @link http://www.w3.org/TR/html5/forms.html#attr-optgroup-label
     */
    public function setLabel(string $label = null) : self
    {
        if ($this->label !== $label) {
            $this->label = $label;
            $this->setChanged(true);
        }
        return $this;
    }

    protected function renderAttributes() : string
    {
        return parent::renderAttributes()
            . Util::renderHtmlAttribute('label', $this->label)
        ;
    }
}
