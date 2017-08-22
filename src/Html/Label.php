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

use \Replum\PageInterface;
use \Replum\Util;

/**
 * @author Dennis Birkholz <dennis@birkholz.org>
 * @link http://www.w3.org/TR/html5/forms.html#the-label-element
 */
final class Label extends HtmlElement
{
    const TAG = 'label';

    /**
     * Restrict allowed children for label elements
     * @param mixed $widget
     */
    protected function validateWidget($widget)
    {
        if (!($widget instanceof PhrasingContentInterface)) {
            throw new \InvalidArgumentException(\get_class($this) . ' can only contain elements implementing the ' . PhrasingElementInterface::class . ' interface');
        }
    }

    /**
     * The element this label is for
     * @var FormElementInterface
     */
    private $htmlFor;

    /**
     * @return FormElementInterface
     */
    public function getFor() : FormElementInterface
    {
        return $this->htmlFor;
    }

    /**
     */
    public function hasFor() : bool
    {
        return ($this->htmlFor !== null);
    }

    /**
     * @return $this
     */
    public function setFor(FormElementInterface $element) : self
    {
        if ($element !== $this->htmlFor) {
            $this->htmlFor = $element;
            $this->setChanged(true);
        }

        return $this;
    }

    /**
     * Add for attribute when printing
     * @return string
     */
    protected function renderAttributes() : string
    {
        return parent::renderAttributes()
            . ($this->hasFor() ? Util::renderHtmlAttribute('for', $this->getFor()->getId()) : '')
        ;
    }

    public static function create(PageInterface $page, FormElementInterface $for = null) : self
    {
        $element = new self($page);
        if ($for !== null) {
            $element->setFor($for);
        }
        return $element;
    }
}
