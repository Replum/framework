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
 * The code element represents a fragment of computer code. This could be an XML element name, a file name, a computer program, or any other string that a computer would recognize.
 *
 * There is no formal way to indicate the language of computer code being marked up. Authors who wish to mark code elements with the language used, e.g. so that syntax highlighting scripts can use the right rules, can use the class attribute, e.g. by adding a class prefixed with "language-" to the element.
 *
 * @author Dennis Birkholz <dennis@birkholz.org>
 * @link https://www.w3.org/TR/html5/text-level-semantics.html#the-code-element
 */
final class Code extends HtmlElement implements PhrasingElementInterface
{
    const TAG = 'code';

    public static function create(PageInterface $page, string $text = null) : self
    {
        $element = new self($page);
        if ($text !== null) {
            $element->add(Text::create($page, $text));
        }
        return $element;
    }
}
