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
 * The dl element represents an association list consisting of zero or more name-value groups (a description list). A name-value group consists of one or more names (dt elements) followed by one or more values (dd elements), ignoring any nodes other than dt and dd elements. Within a single dl element, there should not be more than one dt element for each name.
 *
 * Name-value groups may be terms and definitions, metadata topics and values, questions and answers, or any other groups of name-value data.
 *
 * The values within a group are alternatives; multiple paragraphs forming part of the same value must all be given within the same dd element.
 *
 * The order of the list of groups, and of the names and values within each group, may be significant.
 *
 * @author Dennis Birkholz <dennis@birkholz.org>
 * @link https://www.w3.org/TR/html5/grouping-content.html#the-dl-element
 */
final class Dl extends HtmlElement implements FlowElementInterface
{
    const TAG = 'dl';

    public static function create(PageInterface $page) : self
    {
        return new self($page);
    }
}
