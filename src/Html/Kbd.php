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
 * The kbd element represents user input (typically keyboard input, although it may also be used to represent other input, such as voice commands).
 *
 * When the kbd element is nested inside a samp element, it represents the input as it was echoed by the system.
 *
 * When the kbd element contains a samp element, it represents input based on system output, for example invoking a menu item.
 *
 * When the kbd element is nested inside another kbd element, it represents an actual key or other single unit of input as appropriate for the input mechanism.
 *
 * @author Dennis Birkholz <dennis@birkholz.org>
 * @link https://www.w3.org/TR/html5/text-level-semantics.html#the-kbd-element
 */
final class Kbd extends HtmlElement implements PhrasingElementInterface
{
    const TAG = 'kbd';

    public static function create(PageInterface $page, string $text = null) : self
    {
        $element = new self($page);
        if ($text !== null) {
            $element->add(Text::create($page, $text));
        }
        return $element;
    }
}
