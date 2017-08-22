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
 * @author Dennis Birkholz <dennis@birkholz.org>
 * @link https://www.w3.org/TR/html5/grouping-content.html#the-li-element
 */
class ListElement extends HtmlElement
{
    const TAG = 'li';

    public static function create(PageInterface $page) : self
    {
        return new self($page);
    }

}
