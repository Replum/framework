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

use \Replum\WidgetContainerTrait;

/**
 * @author Dennis Birkholz <dennis@birkholz.org>
 */
abstract class HtmlElement implements WidgetInterface, AriaAttributesInterface
{
    use WidgetContainerTrait;
    use WidgetTrait;
    use AriaAttributesTrait;

    const EMPTY_ELEMENT = false;

    /**
     * {@inheritDoc}
     */
    protected function renderAttributes() : string
    {
        return $this->renderHtmlWidgetAttributes()
            . $this->renderAriaAttributes()
        ;
    }

    public function render() : string
    {
        if (static::EMPTY_ELEMENT) {
            return '<'
                . static::TAG
                . $this->renderAttributes()
                . ' />' . PHP_EOL
            ;
        }

        else {
            return '<'
                . static::TAG
                . $this->renderAttributes()
                . '>'
                . $this->renderChildren()
                . '</' . static::TAG . '>'
            ;
        }
    }
}
