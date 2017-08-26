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
 * The ul element represents a list of items, where the order of the items is not important — that is, where changing the order would not materially change the meaning of the document.
 *
 * The items of the list are the li element child nodes of the ul element.
 *
 * @author Dennis Birkholz <dennis@birkholz.org>
 * @link https://www.w3.org/TR/html5/grouping-content.html#the-ul-element
 */
final class Ul extends HtmlElement implements FlowElementInterface
{
    const TAG = 'ul';

    public static function create(PageInterface $page) : self
    {
        return new self($page);
    }
}
