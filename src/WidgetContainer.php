<?php

/*
 * This file is part of Replum: the web widget framework.
 *
 * Copyright (c) Dennis Birkholz <dennis@birkholz.org>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Replum;

/**
 * @author Dennis Birkholz <dennis@birkholz.org>
 */
class WidgetContainer implements WidgetContainerInterface
{
    use WidgetContainerTrait;

    public function __construct(WidgetInterface $parent = null)
    {
        if ($parent !== null) { $this->setParent($parent); }
    }

    public function __toString()
    {
        return '<' . $this->escape($this->getTag()) . $this->renderAttributes() . '>' . PHP_EOL . $this->renderChildren() . '</' . $this->escape($this->getTag()) . '>';
    }
}
