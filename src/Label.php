<?php

/*
 * This file is part of the nexxes/widgets-html package.
 *
 * Copyright (c) Dennis Birkholz, nexxes Informationstechnik GmbH <dennis.birkholz@nexxes.net>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace nexxes\widgets\html;

use \nexxes\widgets\WidgetContainer;

/**
 * @author Dennis Birkholz <dennis.birkholz@nexxes.net>
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
     * @param \nexxes\widgets\html\FormElementInterface $element
     * @return \nexxes\widgets\html\Label $this for chaining
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
