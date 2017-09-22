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
     * @return static $this for chaining
     */
    public function setValues($values)
    {
        if ($this->values !== $values) {
            $this->values = $values;
            $this->isAssoc = (\array_keys($values) !== \range(0, \count($values)-1));
            $this->setChanged(true);

            foreach ($this->getChildren() as $child) {
                $this->del($child);
            }
            $this->createOptions($this, $this->values);
        }

        return $this;
    }

    /**
     * @return static $this
     * @link http://www.w3.org/TR/html5/forms.html#attr-input-value
     */
    final public function setValue(string $value = null) : FormElementInterface
    {
        if ($this->value !== $value) {
            $this->value = $value;
            $this->setChanged(true);

            /* @var $option Option */
            foreach ($this->getDescendants(Option::class) as $option) {
                $option->setSelected($option->getValue() === $value);
            }
        }
        return $this;
    }

    protected function createOptions($parent, $values)
    {
        foreach ($values as $value => $label) {
            if (\is_array($label)) {
                $optgroup = Html::optGroup()->setLabel($value);
                $parent->add($optgroup);
                $this->{__FUNCTION__}($optgroup, $label);
            }

            else {
                $value = ($this->isAssoc ? $value : $label);
                $option = Html::option()->setLabel($label)->setValue($value);

                if ($value === '') {
                    $option->setDisabled(true);
                    $option->setSelected($this->value === null);
                }

                elseif ($value === $this->value) {
                    $option->setSelected(true);
                }

                $parent->add($option);
            }
        }
    }
}
