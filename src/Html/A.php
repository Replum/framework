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
use \Replum\WidgetHasClickEventInterface;
use \Replum\WidgetHasClickEventTrait;

/**
 * If the a element has an href attribute, then it represents a hyperlink (a hypertext anchor) labeled by its contents.
 *
 * If the a element has no href attribute, then the element represents a placeholder for where a link might otherwise have been placed, if it had been relevant, consisting of just the element's contents.
 *
 * @author Dennis Birkholz <dennis@birkholz.org>
 * @link https://www.w3.org/TR/html5/text-level-semantics.html#the-a-element
 */
final class A extends HtmlElement implements WidgetHasClickEventInterface
{
    use WidgetHasClickEventTrait;

    const TAG = 'a';

    /**
     * Address of the hyperlink
     *
     * @var string
     */
    private $href;

    /**
     * Get the address of the hyperlink
     */
    public function getHref() : string
    {
        return $this->href;
    }

    /**
     * Check whether the address of the hyperlink is set
     */
    public function hasHref() : bool
    {
        return ($this->href !== null);
    }

    /**
     * Set the address of the hyperlink
     *
     * @return $this
     */
    public function setHref(string $newHref) : self
    {
        if ($newHref !== $this->href) {
            $this->href = $newHref;
            $this->setChanged(true);
        }

        return $this;
    }

    /**
     * Default browsing context for hyperlink navigation
     *
     * @var string
     */
    private $target;

    /**
     * Get the default browsing context for hyperlink navigation
     */
    public function getTarget() : string
    {
        return $this->target;
    }

    /**
     * Check whether the default browsing context for hyperlink navigation is set
     */
    public function hasTarget() : bool
    {
        return ($this->target !== null);
    }

    /**
     * set the default browsing context for hyperlink navigation
     *
     * @return $this
     */
    public function setTarget(string $newTarget) : self
    {
        if ($newTarget !== $this->target) {
            $this->target = $newTarget;
            $this->setChanged(true);
        }

        return $this;
    }

    protected function renderAttributes() : string
    {
        return parent::renderAttributes()
            . Util::renderHtmlAttribute('href', $this->href)
            . Util::renderHtmlAttribute('target', $this->target)
        ;
    }

    public static function create(PageInterface $page, string $href = null) : self
    {
        $element = new self($page);
        if ($href !== null) {
            $element->setHref($href);
        }
        return $element;
    }
}
