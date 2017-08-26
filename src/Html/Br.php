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
 * The br element represents a line break.
 *
 * @author Dennis Birkholz <dennis@birkholz.org>
 * @link https://www.w3.org/TR/html5/text-level-semantics.html#the-br-element
 */
final class Br extends HtmlElement implements PhrasingElementInterface
{
    const TAG = 'br';

    public static function create(PageInterface $page) : self
    {
        return new self($page);
    }
}
