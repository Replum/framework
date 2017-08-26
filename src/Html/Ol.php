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
 * The ol element represents a list of items, where the items have been intentionally ordered, such that changing the order would change the meaning of the document.
 *
 * The items of the list are the li element child nodes of the ol element, in tree order.
 *
 * @author Dennis Birkholz <dennis@birkholz.org>
 * @link https://www.w3.org/TR/html5/grouping-content.html#the-ol-element
 */
final class Ol extends HtmlElement implements FlowElementInterface
{
    const TAG = 'ol';

    /**
     * @var int
     * @link http://www.w3.org/TR/html5/grouping-content.html#attr-ol-start
     */
    private $start;

    /**
     * @return int
     * @link http://www.w3.org/TR/html5/grouping-content.html#attr-ol-start
     */
    public function getStart() : int
    {
        return $this->start;
    }

    /**
     * Check whether the start attribute is set
     *
     * @link http://www.w3.org/TR/html5/grouping-content.html#attr-ol-start
     */
    public function hasStart() : bool
    {
        return ($this->start !== null);
    }

    /**
     * @param int $newStart Ordinal value of the first item
     * @return $this
     * @link http://www.w3.org/TR/html5/grouping-content.html#attr-ol-start
     */
    public function setStart(int $newStart = null) : self
    {
        if ($newStart !== $this->start) {
            $this->start = $newStart;
            $this->setChanged(true);
        }

        return $this;
    }

    /**
     * @var bool
     * @link http://www.w3.org/TR/html5/grouping-content.html#attr-ol-reversed
     */
    private $reversed = false;

    /**
     * @return bool
     * @link http://www.w3.org/TR/html5/grouping-content.html#attr-ol-reversed
     */
    public function isReversed() : bool
    {
        return $this->reversed;
    }

    /**
     * @return $this
     * @link http://www.w3.org/TR/html5/grouping-content.html#attr-ol-reversed
     */
    public function setReversed(bool $newReversed) : self
    {
        if ($newReversed !== $this->reversed) {
            $this->reversed = $newReversed;
            $this->setChanged(true);
        }

        return $this;
    }

    /**
     * List uses decimal numbers (1. 2. 3. ...)
     * @link http://www.w3.org/TR/html5/grouping-content.html#attr-ol-type
     */
    const TYPE_DECIMAL = '1';

    /**
     * List uses lowercase latin alphabet (a. b. c. ...)
     * @link http://www.w3.org/TR/html5/grouping-content.html#attr-ol-type
     */
    const TYPE_LOWER_ALPHA = 'a';

    /**
     * List uses uppercase latin alphabet (A. B. C. ...)
     * @link http://www.w3.org/TR/html5/grouping-content.html#attr-ol-type
     */
    const TYPE_UPPER_ALPHA = 'A';

    /**
     * List uses lowercase roman numerals (i. ii. iii. iv. ...)
     * @link http://www.w3.org/TR/html5/grouping-content.html#attr-ol-type
     */
    const TYPE_LOWER_ROMAN = 'i';

    /**
     * List uses uppercase roman numerals (I. II. III. IV. ...)
     * @link http://www.w3.org/TR/html5/grouping-content.html#attr-ol-type
     */
    const TYPE_UPPER_ROMAN = 'I';

    /**
     * Type of the listing, one of the TYPE_* constants
     * @link http://www.w3.org/TR/html5/grouping-content.html#attr-ol-type
     */
    private $type;

    /**
     * Get the current type if list is ordered
     * @return string
     * @link http://www.w3.org/TR/html5/grouping-content.html#attr-ol-type
     */
    public function getType() : string
    {
        return $this->type;
    }

    /**
     * Check whether a type is set or the default is used
     * @link http://www.w3.org/TR/html5/grouping-content.html#attr-ol-type
     */
    public function hasType() : bool
    {
        return ($this->type !== null);
    }

    /**
     * Set the current type if the list is ordered
     *
     * @return $this
     * @link http://www.w3.org/TR/html5/grouping-content.html#attr-ol-type
     */
    public function setType(string $newType = null) : self
    {
        $constants = (new \ReflectionClass(self::class))->getConstants();

        if (!\in_array($newType, \array_values($constants))) {
            throw new \UnexpectedValueException('Invalid list type "' . $newType . '", valid types are: ' . __CLASS__ . '::' . \implode(', ' . __CLASS__ . '::', \array_keys($constants)));
        }

        if ($newType !== $this->type) {
            $this->type = $newType;
            $this->setChanged(true);
        }

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    protected function renderAttributes() : string
    {
        return parent::renderAttributes()
            . Util::renderHtmlAttribute('reversed', ($this->isReversed() ? 'reversed' : null))
            . Util::renderHtmlAttribute('start', $this->start)
            . Util::renderHtmlAttribute('type', $this->type)
        ;
    }

    public static function create(PageInterface $page) : self
    {
        return new self($page);
    }
}
