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
 * The sup element represents a superscript and the sub element represents a subscript.
 *
 * These elements must be used only to mark up typographical conventions with specific meanings, not for typographical presentation for presentation's sake. For example, it would be inappropriate for the sub and sup elements to be used in the name of the LaTeX document preparation system. In general, authors should use these elements only if the absence of those elements would change the meaning of the content.
 *
 * In certain languages, superscripts are part of the typographical conventions for some abbreviations.
 *
 * @author Dennis Birkholz <dennis@birkholz.org>
 * https://www.w3.org/TR/html5/text-level-semantics.html#the-sub-and-sup-elements
 */
final class Sub extends HtmlElement implements PhrasingElementInterface
{
    const TAG = 'sub';

    public static function create(PageInterface $page, string $text = null) : self
    {
        $element = new self($page);
        if ($text !== null) {
            $element->add(Text::create($page, $text));
        }
        return $element;
    }
}
