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
use \Replum\Util;

/**
 * The data element represents its contents, along with a machine-readable form of those contents in the value attribute.
 *
 * The value attribute must be present. Its value must be a representation of the element's contents in a machine-readable format.
 *
 * @author Dennis Birkholz <dennis@birkholz.org>
 * @link https://www.w3.org/TR/html5/text-level-semantics.html#the-data-element
 */
final class Data extends HtmlElement implements PhrasingElementInterface
{
    const TAG = 'data';

    /**
     * @var string
     */
    private $value;

    public function getValue() : string
    {
        return $this->value;
    }

    public function hasValue() : bool
    {
        return ($this->value !== null);
    }

    public function setValue(string $value = null) : self
    {
        if ($this->value !== $value) {
            $this->value = $value;
            $this->setChanged(true);
        }

        return $this;
    }

    protected function renderAttributes() : string
    {
        return parent::renderAttributes()
            . Util::renderHtmlAttribute('value', $this->value);
    }

    public static function create(PageInterface $page, string $text = null) : self
    {
        $element = new self($page);
        if ($text !== null) {
            $element->add(Text::create($page, $text));
        }
        return $element;
    }
}
