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
 * The h1–h6 elements are headings.
 *
 * The first element of heading content in an element of sectioning content represents the heading for that section. Subsequent headings of equal or higher rank start new (implied) sections, headings of lower rank start implied subsections that are part of the previous one. In both cases, the element represents the heading of the implied section.
 *
 * h1–h6 elements must not be used to markup subheadings, subtitles, alternative titles and taglines unless intended to be the heading for a new section or subsection. Instead use the markup patterns in the Common idioms without dedicated elements section of the specification.
 *
 * Certain elements are said to be sectioning roots, including blockquote and td elements. These elements can have their own outlines, but the sections and headings inside these elements do not contribute to the outlines of their ancestors.
 *
 * @author Dennis Birkholz <dennis@birkholz.org>
 * @link https://www.w3.org/TR/html5/sections.html#the-h1,-h2,-h3,-h4,-h5,-and-h6-elements
 * @link https://www.w3.org/TR/html5/sections.html#headings-and-sections
 */
final class H1 extends HtmlElement implements FlowElementInterface
{
    const TAG = 'h1';

    public static function create(PageInterface $page, string $text = null) : self
    {
        $element = new self($page);
        if ($text !== null) {
            $element->add(Text::create($page, $text));
        }
        return $element;
    }
}
