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
 * The main element represents the main content of the body of a document or application. The main content area consists of content that is directly related to or expands upon the central topic of a document or central functionality of an application.
 *
 * @author Dennis Birkholz <dennis@birkholz.org>
 * @link http://www.w3.org/TR/html5/grouping-content.html#the-main-element
 */
final class Main extends HtmlElement
{
    const TAG = 'main';

    public static function create(PageInterface $page) : self
    {
        return new self($page);
    }
}
