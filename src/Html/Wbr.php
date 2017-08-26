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
 * The wbr element represents a line break opportunity.
 *
 * @author Dennis Birkholz <dennis@birkholz.org>
 * @link https://www.w3.org/TR/html5/text-level-semantics.html#the-wbr-element
 */
final class Wbr extends HtmlElement implements PhrasingElementInterface
{
    const TAG = 'wbr';

    public static function create(PageInterface $page) : self
    {
        return new self($page);
    }
}
