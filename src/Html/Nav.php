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
 * The nav element represents a section of a page that links to other pages or to parts within the page: a section with navigation links.
 *
 * @author Dennis Birkholz <dennis@birkholz.org>
 * @link https://www.w3.org/TR/html5/sections.html#the-nav-element
 */
final class Nav extends HtmlElement implements FlowElementInterface
{
    const TAG = 'nav';

    public static function create(PageInterface $page) : self
    {
        return new self($page);
    }
}
