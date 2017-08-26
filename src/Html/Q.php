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
 * The q element represents some phrasing content quoted from another source.
 *
 * Quotation punctuation (such as quotation marks) that is quoting the contents of the element must not appear immediately before, after, or inside q elements; they will be inserted into the rendering by the user agent.
 *
 * Content inside a q element must be quoted from another source, whose address, if it has one, may be cited in the cite attribute. The source may be fictional, as when quoting characters in a novel or screenplay.
 *
 * If the cite attribute is present, it must be a valid URL potentially surrounded by spaces. To obtain the corresponding citation link, the value of the attribute must be resolved relative to the element. User agents may allow users to follow such citation links, but they are primarily intended for private use (e.g. by server-side scripts collecting statistics about a site's use of quotations), not for readers.
 *
 * The q element must not be used in place of quotation marks that do not represent quotes; for example, it is inappropriate to use the q element for marking up sarcastic statements.
 *
 * The use of q elements to mark up quotations is entirely optional; using explicit quotation punctuation without q elements is just as correct.
 *
 * @author Dennis Birkholz <dennis@birkholz.org>
 * @link https://www.w3.org/TR/html5/text-level-semantics.html#the-q-element
 */
final class Q extends HtmlElement implements PhrasingElementInterface
{
    const TAG = 'q';

    public static function create(PageInterface $page, string $text = null) : self
    {
        $element = new self($page);
        if ($text !== null) {
            $element->add(Text::create($page, $text));
        }
        return $element;
    }
}
