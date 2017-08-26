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

use \Replum\PageInterface;

/**
 * The figcaption element represents a caption or legend for the rest of the contents of the figcaption element's parent figure element, if any.
 *
 * @author Dennis Birkholz <dennis@birkholz.org>
 * @link https://www.w3.org/TR/html5/grouping-content.html#the-figcaption-element
 */
final class FigCaption extends HtmlElement implements FlowElementInterface
{
    const TAG = 'figcaption';

    public final static function create(PageInterface $page) : self
    {
        return new self($page);
    }
}
