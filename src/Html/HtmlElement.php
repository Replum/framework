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

/**
 * @author Dennis Birkholz <dennis@birkholz.org>
 */
abstract class HtmlElement implements WidgetInterface, AriaAttributesInterface
{
    use \Replum\WidgetContainerTrait;
    use WidgetTrait;
    use AriaAttributesTrait;

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
        return '<'
            . static::TAG
            . $this->renderAttributes()
            . '>' . PHP_EOL
            . $this->renderChildren() . PHP_EOL
            . '</' . static::TAG . '>' . PHP_EOL;
    }
}
