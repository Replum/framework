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
 * The u element represents a span of text with an unarticulated, though explicitly rendered, non-textual annotation, such as labeling the text as being a proper name in Chinese text (a Chinese proper name mark), or labeling the text as being misspelt.
 *
 * In most cases, another element is likely to be more appropriate: for marking stress emphasis, the em element should be used; for marking key words or phrases either the b element or the mark element should be used, depending on the context; for marking book titles, the cite element should be used; for labeling text with explicit textual annotations, the ruby element should be used; for labeling ship names in Western texts, the i element should be used.
 *
 * @author Dennis Birkholz <dennis@birkholz.org>
 * @link https://www.w3.org/TR/html5/text-level-semantics.html#the-u-element
 */
final class U extends HtmlElement implements PhrasingElementInterface
{
    const TAG = 'u';

    public static function create(PageInterface $page, string $text = null) : self
    {
        $element = new self($page);
        if ($text !== null) {
            $element->add(Text::create($page, $text));
        }
        return $element;
    }
}
