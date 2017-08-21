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

use \Replum\WidgetContainer;
use \Replum\WidgetInterface;

/**
 * @author Dennis Birkholz <dennis@birkholz.biz>
 * @property string $label User-visible label
 * @link http://www.w3.org/TR/html5/forms.html#the-optgroup-element
 */
class OptionGroup extends WidgetContainer
{
    /**
     * @var string
     * @link http://www.w3.org/TR/html5/forms.html#attr-optgroup-label
     */
    protected $label;

    /**
     * @return string
     * @link http://www.w3.org/TR/html5/forms.html#attr-optgroup-label
     */
    public function getLabel()
    {
        return $this->label;
    }

    /**
     * @param string $newLabel
     * @return static $this for chaining
     * @link http://www.w3.org/TR/html5/forms.html#attr-optgroup-label
     */
    public function setLabel($newLabel)
    {
        return $this->setStringProperty('label', $newLabel);
    }

    public function renderAttributes()
    {
        return parent::renderAttributes()
        . $this->renderHtmlAttribute('label', $this->label);
    }

    public function __construct(WidgetInterface $parent = null)
    {
        parent::__construct($parent);
        $this->setTag('optgroup');
    }
}
