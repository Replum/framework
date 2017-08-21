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

use \Replum\WidgetInterface;
use \Replum\WidgetTrait;
use \Replum\WidgetHasChangeEventInterface;
use \Replum\WidgetHasChangeEventTrait;

/**
 * @author Dennis Birkholz <dennis@birkholz.org>
 * @property boolean $checked Checkbox is activated or not
 * @property boolean $required Element must be filled.
 */
class RadioButton implements FormInputInterface, WidgetHasChangeEventInterface
{
    use WidgetTrait,
        WidgetHasChangeEventTrait,
        FormInputTrait {
        isChecked as public;
        enableChecked as public;
        disableChecked as public;
        setChecked as protected setCheckedFromTrait;

        isRequired as public;
        enableRequired as public;
        disableRequired as public;
    }

    public function __construct(WidgetInterface $parent = null)
    {
        if (!is_null($parent)) { $this->setParent($parent); }
        $this->setType('radio');
    }

    public function __toString()
    {
        return '<input'
        . $this->renderAttributes()
        . $this->renderFormInputAttributes()
        . ' />';
    }

    public function setChecked($newChecked)
    {
        $this->setCheckedFromTrait($newChecked);
        if ($this->isChecked()) {
            $root = ($this->getForm() !== null ? $this->getForm() : $this->getRoot());

            foreach ($root->getDescendants(RadioButton::class) as $elem) {
                /* @var $elem RadioButton */
                if (($elem->name == $this->name) && ($elem !== $this)) {
                    $elem->setChecked(false);
                }
            }
        }

        return $this;
    }
}
