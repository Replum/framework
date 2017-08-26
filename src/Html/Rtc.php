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
 * The rtc element marks a ruby text container for ruby text components in a ruby annotation. When it is the child of a ruby element it doesn't represent anything itself, but its parent ruby element uses it as part of determining what it represents.
 *
 * An rtc element that is not a child of a ruby element represents the same thing as its children.
 *
 * @author Dennis Birkholz <dennis@birkholz.org>
 * @link https://www.w3.org/TR/html5/text-level-semantics.html#the-rtc-element
 */
final class Rtc extends HtmlElement implements PhrasingElementInterface
{
    const TAG = 'rtc';

    public static function create(PageInterface $page, string $text = null) : self
    {
        $element = new self($page);
        if ($text !== null) {
            $element->add(Text::create($page, $text));
        }
        return $element;
    }
}
