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
 * The footer element represents a footer for its nearest ancestor sectioning content or sectioning root element. A footer typically contains information about its section such as who wrote it, links to related documents, copyright data, and the like.
 *
 * When the footer element contains entire sections, they represent appendices, indexes, long colophons, verbose license agreements, and other such content.
 *
 * @author Dennis Birkholz <dennis@birkholz.org>
 * @link https://www.w3.org/TR/html5/sections.html#the-footer-element
 */
final class Footer extends HtmlElement implements FlowElementInterface
{
    const TAG = 'footer';

    public final static function create(PageInterface $page) : self
    {
        return new self($page);
    }
}
