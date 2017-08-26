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
 *  The ruby element allows one or more spans of phrasing content to be marked with ruby annotations. Ruby annotations are short runs of text presented alongside base text, primarily used in East Asian typography as a guide for pronunciation or to include other annotations. In Japanese, this form of typography is also known as furigana. Ruby text can appear on either side, and sometimes both sides, of the base text, and it is possible to control its position using CSS. A more complete introduction to ruby can be found in the Use Cases & Exploratory Approaches for Ruby Markup document as well as in CSS Ruby Module Level 1. [RUBY-UC] [CSSRUBY]
 *
 * The content model of ruby elements consists of one or more of the following sequences:
 * - One or more phrasing content nodes or rb elements.
 * - One or more rt or rtc elements, each of which either immediately preceded or followed by an rp elements.
 *
 * The ruby, rb, rtc, and rt elements can be used for a variety of kinds of annotations, including in particular (though by no means limited to) those described below. For more details on Japanese Ruby in particular, and how to render Ruby for Japanese, see Requirements for Japanese Text Layout. [JLREQ] The rp element can be used as fallback content when ruby rendering is not supported.
 *
 * @author Dennis Birkholz <dennis@birkholz.org>
 * @link https://www.w3.org/TR/html5/text-level-semantics.html#the-ruby-element
 */
final class Ruby extends HtmlElement implements PhrasingElementInterface
{
    const TAG = 'ruby';

    public static function create(PageInterface $page) : self
    {
        return new self($page);
    }
}
