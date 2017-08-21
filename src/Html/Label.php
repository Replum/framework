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

/**
 * @author Dennis Birkholz <dennis@birkholz.org>
 * @link http://www.w3.org/TR/html5/forms.html#the-label-element
 */
class Label extends WidgetContainer
{
    /**
     * {@inheritdoc}
     */
    public function validTags()
    {
        return [ 'label'];
    }

    /**
     * Restrict allowed children for label elements
     * @param mixed $widget
     */
    protected function validateWidget($widget)
    {
        if (!($widget instanceof PhrasingContentInterface)) {
            throw new \InvalidArgumentException(\get_class($this) . ' can only contain elements implementing the ' . PhrasingContentInterface::class . ' interface');
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
    public function getFor()
    {
        return $this->htmlFor;
    }

    /**
     * @param \Replum\Html\FormElementInterface $element
     * @return \Replum\Html\Label $this for chaining
     */
    public function setFor(FormElementInterface $element)
    {
        if ($element !== $this->htmlFor) {
            $this->setChanged(true);
        }

        $this->htmlFor = $element;
        return $this;
    }

    /**
     * Add for attribute when printing
     * @return string
     */
    protected function renderAttributes()
    {
        return ($this->getFor() !== null ? ' for="' . $this->escape($this->getFor()->getID()) . '"' : '')
        . parent::renderAttributes();
    }
}
