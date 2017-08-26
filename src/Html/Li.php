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
 * The li element represents a list item. If its parent element is an ol, or ul, then the element is an item of the parent element's list, as defined for those elements. Otherwise, the list item has no defined list-related relationship to any other li element.
 *
 * If the parent element is an ol element, then the li element has an ordinal value.
 *
 * @author Dennis Birkholz <dennis@birkholz.org>
 * @link https://www.w3.org/TR/html5/grouping-content.html#the-li-element
 */
final class Li extends HtmlElement
{
    const TAG = 'li';

    /**
     * @var int
     */
    private $value;

    public function getValue() : int
    {
        return $this->value;
    }

    public function hasValue() : bool
    {
        return $this->value !== null;
    }

    public function setValue(int $value = null) : self
    {
        if ($this->value !== $value) {
            $this->value = $value;
            $this->setChanged(true);
        }

        return $this;
    }

    public static function create(PageInterface $page) : self
    {
        return new self($page);
    }
}
