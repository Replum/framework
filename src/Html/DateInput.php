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
 */
class DateInput implements FormInputInterface, WidgetHasChangeEventInterface
{
    use WidgetTrait,
        WidgetHasChangeEventTrait,
        FormInputTrait {
        hasAutocomplete as public;
        enableAutocomplete as public;
        disableAutocomplete as public;
        unsetAutocomplete as public;

        hasAutofocus as public;
        enableAutofocus as public;
        disableAutofocus as public;

        getPlaceholder as public;
        setPlaceholder as public;

        isReadonly as public;
        enableReadonly as public;
        disableReadonly as public;

        isRequired as public;
        enableRequired as public;
        disableRequired as public;
    }

    public $locale = 'de-DE';

    /**
     * @param \Replum\WidgetInterface $parent
     * @param string $name
     */
    public function __construct(WidgetInterface $parent = null)
    {
        if (!is_null($parent)) { $this->setParent($parent); }
        $this->setType('text');
    }

    public function __toString()
    {
        $this->setData('provide', 'datepicker');
        $this->setData('dateLanguage', $this->locale);
        $this->setData('dateAutoclose', '1');

        return '<input'
        . $this->renderAttributes()
        . $this->renderFormInputAttributes()
        . ' />';
    }
}
