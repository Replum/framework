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
 * The body element represents the content of the document.
 *
 * In conforming documents, there is only one body element. The document.body IDL attribute provides scripts with easy access to a document's body element.
 *
 * @author Dennis Birkholz <dennis@birkholz.org>
 * @link https://www.w3.org/TR/html5/sections.html#the-body-element
 */
final class Body extends HtmlElement
{
    const TAG = 'body';

    public static function create(PageInterface $page) : self
    {
        return new self($page);
    }
}
