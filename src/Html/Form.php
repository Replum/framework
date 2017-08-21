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
use \Replum\WidgetCollection;
use \Replum\WidgetInterface;
use \Replum\WidgetHasSubmitEventInterface;
use \Replum\WidgetHasSubmitEventTrait;

/**
 * @author Dennis Birkholz <dennis@birkholz.org>
 * @property-read WidgetCollection $elements
 */
class Form extends WidgetContainer implements WidgetHasSubmitEventInterface
{
    use WidgetHasSubmitEventTrait;

    /**
     * @var string
     * @link http://www.w3.org/TR/html5/forms.html#attr-fs-action
     */
    private $action;

    /**
     * @return string
     * @link http://www.w3.org/TR/html5/forms.html#attr-fs-action
     */
    public function getAction()
    {
        return $this->action;
    }

    /**
     * @param string $newAction
     * @return \Replum\Html\Form $this for chaining
     * @link http://www.w3.org/TR/html5/forms.html#attr-fs-action
     */
    public function setAction($newAction)
    {
        if ($newAction !== $this->action) {
            $this->action = $newAction;
            $this->setChanged(true);
        }

        return $this;
    }

    /**
     * @var string
     * @link http://www.w3.org/TR/html5/forms.html#attr-form-name
     */
    private $name;

    /**
     * @return string
     * @link http://www.w3.org/TR/html5/forms.html#attr-form-name
     */
    public function getName()
    {
        return $this->action;
    }

    /**
     * @param string $newName
     * @return \Replum\Html\Form $this for chaining
     * @link http://www.w3.org/TR/html5/forms.html#attr-form-name
     */
    public function setName($newName)
    {
        if ($newName !== $this->name) {
            $this->name = $newName;
            $this->setChanged(true);
        }

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function setParent(WidgetInterface $newParent)
    {
        parent::setParent($newParent);

        if ($this->isChanged()) {
            foreach ($this->getAncestors(Form::class) as $ancestor) {
                throw new \InvalidArgumentException('A form element can not contain another form element, see: http://www.w3.org/TR/html5/forms.html#the-form-element');
            }
        }

        return $this;
    }

    /**
     * @var WidgetCollection
     */
    private $elements;

    /**
     * @return \Traversable<FormInputInterface>
     */
    public function getElements()
    {
        /* @var $element FormInputInterface */
        foreach ($this->getDescendants(FormInputInterface::class) as $element) {
            // For nested input, use only the topmost
            if (null !== $element->getNearestAncestor(FormInputInterface::class)) { continue; }

            yield $element;
        }
    }

    /**
     * Get a form field (that can has input) by name (or ID)
     *
     * @param string $nameOrId
     * @return FormInputInterface
     */
    public function getField($nameOrId)
    {
        foreach ($this->getDescendants(FormInputInterface::class) as $field) {
            if (($field->name === $nameOrId) || ($field->id === $nameOrId)) {
                return $field;
            }
        }

        return null;
    }

    public function __toString()
    {
        $r = '<form role="form"'
        . $this->renderAttributes()
        . '>' . "\n";

        foreach ($this->children() AS $widget) {
            $r .= $widget . "\n";
        }

        $r .= '</form>' . "\n";

        return $r;
    }
}
