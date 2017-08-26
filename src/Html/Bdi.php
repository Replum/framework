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
 * The bdi element represents a span of text that is to be isolated from its surroundings for the purposes of bidirectional text formatting.
 *
 * @author Dennis Birkholz <dennis@birkholz.org>
 * @link https://www.w3.org/TR/html5/text-level-semantics.html#the-bdi-element
 * @link http://www.unicode.org/reports/tr9/ UAX #9: Unicode Bidirectional Algorithm
 */
final class Bdi extends HtmlElement implements PhrasingElementInterface
{
    const TAG = 'bdi';

    public static function create(PageInterface $page, string $text = null) : self
    {
        $element = new self($page);
        if ($text !== null) {
            $element->add(Text::create($page, $text));
        }
        return $element;
    }
}
