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
 * The del element represents a removal from the document.
 *
 * del elements should not cross implied paragraph boundaries.
 *
 * @author Dennis Birkholz <dennis@birkholz.org>
 * @link https://www.w3.org/TR/html5/edits.html#the-ins-element
 */
final class Del extends HtmlElement implements PhrasingElementInterface
{
    const TAG = 'del';

    /**
     * Link to the source of the quotation or more information about the edit
     *
     * @string
     * @link https://www.w3.org/TR/html5/edits.html#attr-mod-cite
     */
    private $cite;

    /**
     * Get the link to the source of the quotation or more information about the edit
     * @link https://www.w3.org/TR/html5/edits.html#attr-mod-cite
     */
    public function getCite() : string
    {
        return $this->cite;
    }

    /**
     * Check whether a link to the source of the quotation or more information about the edit has been set
     * @link https://www.w3.org/TR/html5/edits.html#attr-mod-cite
     */
    public function hasCite() : bool
    {
        return $this->cite !== null;
    }

    /**
     * Set or clear the link to the source of the quotation or more information about the edit
     * @link https://www.w3.org/TR/html5/edits.html#attr-mod-cite
     */
    public function setCite(string $cite = null) : self
    {
        if ($this->cite !== $cite) {
            $this->cite = $cite;
            $this->setChanged(true);
        }

        return $this;
    }

    /**
     * Date and (optionally) time of the change
     *
     * @string
     * @link https://www.w3.org/TR/html5/edits.html#attr-mod-datetime
     */
    private $dateTime;

    /**
     * Get the date and (optionally) time of the change
     *
     * @link https://www.w3.org/TR/html5/edits.html#attr-mod-datetime
     */
    public function getDateTime() : string
    {
        return $this->dateTime;
    }

    /**
     * Check whether the date and (optionally) time of the change has been set
     *
     * @link https://www.w3.org/TR/html5/edits.html#attr-mod-datetime
     */
    public function hasDateTime() : bool
    {
        return $this->dateTime !== null;
    }

    /**
     * Set or clear the date and (optionally) time of the change
     *
     * @link https://www.w3.org/TR/html5/edits.html#attr-mod-datetime
     */
    public function setDateTime(string $dateTime = null) : self
    {
        if ($this->dateTime !== $dateTime) {
            $this->dateTime = $dateTime;
            $this->setChanged(true);
        }

        return $this;
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
