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

use \Replum\HtmlFactory as Html;
use \Replum\Util;
use \Replum\WidgetHasChangeEventInterface;
use \Replum\WidgetHasChangeEventTrait;

/**
 * @author Dennis Birkholz <dennis@birkholz.org>
 */
final class Select extends HtmlElement implements WidgetHasChangeEventInterface, FormInputInterface
{
    use FormElementTrait;
    use WidgetHasChangeEventTrait;

    const TAG = 'select';

    ######################################################################
    # autofocus attribute                                                #
    ######################################################################

    // from FormElementTrait

    ######################################################################
    # disabled attribute                                                 #
    ######################################################################

    // from FormElementTrait

    ######################################################################
    # form attribute                                                     #
    ######################################################################

    // from FormElementTrait

    ######################################################################
    # multiple attribute                                                 #
    ######################################################################

    /**
     * @var bool
     * @link https://www.w3.org/TR/html5/forms.html#attr-select-multiple
     */
    private $multiple = false;

    /**
     * @link https://www.w3.org/TR/html5/forms.html#attr-select-multiple
     */
    final public function getMultiple() : bool
    {
        return $this->multiple;
    }

    /**
     * @link https://www.w3.org/TR/html5/forms.html#attr-select-multiple
     */
    final public function setMultiple(bool $multiple) : self
    {
        if ($this->multiple !== $multiple) {
            $this->multiple = $multiple;
            $this->setChanged(true);
        }
        return $this;
    }

    ######################################################################
    # name attribute                                                     #
    ######################################################################

    // from FormElementTrait

    ######################################################################
    # required attribute                                                 #
    ######################################################################

    // from FormElementTrait

    ######################################################################
    # size attribute                                                     #
    ######################################################################

    /**
     * @var int
     * @link https://www.w3.org/TR/html5/forms.html#attr-select-size
     */
    private $size;

    /**
     * @link https://www.w3.org/TR/html5/forms.html#attr-select-size
     */
    final public function getSize() : int
    {
        return $this->size;
    }

    /**
     * @link https://www.w3.org/TR/html5/forms.html#attr-select-size
     */
    final public function hasSize() : bool
    {
        return ($this->size !== null);
    }

    /**
     * @link https://www.w3.org/TR/html5/forms.html#attr-select-size
     */
    final public function setSize(int $size = null) : self
    {
        if ($size !== null && $size < 1) {
            throw new \InvalidArgumentException("The size of a select element must be 1 or greater!");
        }

        if ($this->size !== $size) {
            $this->size = $size;
            $this->setChanged(true);
        }
        return $this;
    }

    ######################################################################
    # rendering                                                          #
    ######################################################################

    protected function renderAttributes() : string
    {
        return parent::renderAttributes()
        . Util::renderHtmlAttribute('name', $this->name)
        . Util::renderHtmlAttribute('size', $this->size)
        ;
    }

    public function render() : string
    {
        if (!\count($this->children()) && \count($this->values)) {
            $this->createOptions($this, $this->values);
        }

        return parent::render();
    }

    ######################################################################
    # helper functions                                                   #
    ######################################################################

    /**
     * @var array
     */
    protected $values;

    /**
     * @var boolean
     */
    protected $isAssoc;

    /**
     * @return array
     */
    public function getValues()
    {
        return $this->values;
    }

    /**
     * @param array $values
     * @param boolean $hasKeys $values contains separate values and labels
     * @return static $this for chaining
     */
    public function setValues($values, $hasKeys = true)
    {
        if (($this->values !== $values) && ($this->isAssoc !== $hasKeys)) {
            $this->values = $values;
            $this->isAssoc = (bool) $hasKeys;
            $this->setChanged(true);
        }
        return $this;
    }

    protected function createOptions($parent, $values)
    {
        foreach ($values as $value => $label) {
            if (\is_array($label)) {
                $optgroup = Html::optGroup($this->getPage())->setLabel($value);
                $parent->add($optgroup);
                $this->{__FUNCTION__}($optgroup, $label);
            }

            else {
                $option = Html::option($this->getPage())->setLabel($label)->setValue($this->isAssoc ? $value : $label);
                if (($this->value !== null) && ($value === $this->value)) {
                    $option->setSelected(true);
                }
                $parent->add($option);
            }
        }
    }
}
