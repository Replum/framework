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
 * The b element represents a span of text to which attention is being drawn for utilitarian purposes without conveying any extra importance and with no implication of an alternate voice or mood, such as key words in a document abstract, product names in a review, actionable words in interactive text-driven software, or an article lede.
 *
 * @author Dennis Birkholz <dennis@birkholz.org>
 * @link https://www.w3.org/TR/html5/text-level-semantics.html#the-b-element
 */
final class B extends HtmlElement implements PhrasingElementInterface
{
    const TAG = 'b';

    public static function create(PageInterface $page, string $text = null) : self
    {
        $element = new self($page);
        if ($text !== null) {
            $element->add(Text::create($page, $text));
        }
        return $element;
    }
}
