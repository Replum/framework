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
 * The aside element represents a section of a page that consists of content that is tangentially related to the content around the aside element, and which could be considered separate from that content. Such sections are often represented as sidebars in printed typography.
 *
 * The element can be used for typographical effects like pull quotes or sidebars, for advertising, for groups of nav elements, and for other content that is considered separate from the main content of the page.
 *
 * @author Dennis Birkholz <dennis@birkholz.org>
 * @link http://www.w3.org/TR/html5/sections.html#the-aside-element
 */
final class Aside extends HtmlElement
{
    const TAG = 'aside';

    public static function create(PageInterface $page) : self
    {
        return new self($page);
    }
}
