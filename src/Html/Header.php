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
 * The header element represents introductory content for its nearest ancestor sectioning content or sectioning root element. A header typically contains a group of introductory or navigational aids.
 *
 * When the nearest ancestor sectioning content or sectioning root element is the body element, then it applies to the whole page.
 *
 * @author Dennis Birkholz <dennis@birkholz.org>
 * @link https://www.w3.org/TR/html5/sections.html#the-header-element
 */
final class Header extends HtmlElement implements FlowElementInterface
{
    const TAG = 'header';

    public final static function create(PageInterface $page) : self
    {
        return new self($page);
    }
}
