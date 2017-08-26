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
 * The bdo element represents explicit text directionality formatting control for its children. It allows authors to override the Unicode bidirectional algorithm by explicitly specifying a direction override.
 *
 * Authors must specify the dir attribute on this element, with the value ltr to specify a left-to-right override and with the value rtl to specify a right-to-left override. The auto value must not be specified.
 *
 * @author Dennis Birkholz <dennis@birkholz.org>
 * @link https://www.w3.org/TR/html5/text-level-semantics.html#the-bdo-element
 * @link http://www.unicode.org/reports/tr9/ UAX #9: Unicode Bidirectional Algorithm
 */
final class Bdo extends HtmlElement implements PhrasingElementInterface
{
    const TAG = 'bdo';

    public static function create(PageInterface $page, string $text = null) : self
    {
        $element = new self($page);
        if ($text !== null) {
            $element->add(Text::create($page, $text));
        }
        return $element;
    }
}
