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
 * @todo: implement dirname attribute
 */
abstract class Input extends HtmlElement implements FormInputInterface
{
    use FormElementTrait;

    const AUTOCOMPLETE_ON = 'on';
    const AUTOCOMPLETE_OFF = 'off';

    protected function renderAttributes() : string
    {
        return parent::renderAttributes()
            . $this->renderFormElementAttributes()
            . Util::renderHtmlAttribute('autofocus', $this->autofocus)
            . Util::renderHtmlAttribute('disabled', $this->disabled)
            . Util::renderHtmlAttribute('name', $this->name)
            . Util::renderHtmlAttribute('type', static::TYPE)
            . Util::renderHtmlAttribute('value', $this->value)
        ;
    }
}
