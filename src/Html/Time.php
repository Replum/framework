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
 * The time element represents its contents, along with a machine-readable form of those contents in the datetime attribute. The kind of content is limited to various kinds of dates, times, time-zone offsets, and durations, as described below.
 *
 * The datetime attribute may be present. If present, its value must be a representation of the element's contents in a machine-readable format.
 *
 * A time element that does not have a datetime content attribute must not have any element descendants.
 *
 * The datetime value of a time element is the value of the element's datetime content attribute, if it has one, or the element's textContent, if it does not.
 *
 * @author Dennis Birkholz <dennis@birkholz.org>
 * @link https://www.w3.org/TR/html5/text-level-semantics.html#the-time-element
 */
final class Time extends HtmlElement implements PhrasingElementInterface
{
    const TAG = 'time';

    /**
     * @string
     */
    private $dateTime;

    public function getDateTime() : string
    {
        return $this->dateTime;
    }

    public function hasDateTime() : bool
    {
        return $this->dateTime !== null;
    }

    public function setDateTime(string $dateTime = null) : self
    {
        if ($this->dateTime !== $dateTime) {
            $this->dateTime = $dateTime;
            $this->setChanged(true);
        }

        return $this;
    }

    public static function create(PageInterface $page, string $text = null) : self
    {
        $element = new self($page);
        if ($text !== null) {
            $element->add(Text::create($page, $text));
        }
        return $element;
    }
}
