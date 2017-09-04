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

use Replum\Util;

/**
 * Default implementation of the TableCellInterface
 *
 * @author Dennis Birkholz <dennis@birkholz.org>
 */
abstract class TableCellElement extends HtmlElement implements TableCellElementInterface
{
    ######################################################################
    # colspan attribute                                                  #
    ######################################################################

    /**
     * Number of columns that the cell is to span
     *
     * @var int
     * @link https://www.w3.org/TR/html5/tabular-data.html#attr-tdth-colspan
     */
    private $colspan;

    /**
     * @see TableCellElementInterface::getColspan()
     */
    final public function getColspan() : int
    {
        return $this->colspan;
    }

    /**
     * @see TableCellElementInterface::hasColspan()
     */
    final public function hasColspan() : bool
    {
        return ($this->colspan !== null);
    }

    /**
     * @see TableCellElementInterface::setColspan()
     */
    final public function setColspan(int $colspan = null) : TableCellElementInterface
    {
        if ($this->colspan !== $colspan) {
            $this->colspan = $colspan;
            $this->setChanged(true);
        }
        return $this;
    }

    ######################################################################
    # rowspan attribute                                                  #
    ######################################################################

    /**
     * Number of rows that the cell is to span
     *
     * @var int
     * @link https://www.w3.org/TR/html5/tabular-data.html#attr-tdth-rowspan
     */
    private $rowspan;

    /**
     * @see TableCellElementInterface::getRowspan()
     */
    final public function getRowspan() : int
    {
        return $this->rowspan;
    }

    /**
     * @see TableCellElementInterface::hasRowspan()
     */
    final public function hasRowspan() : bool
    {
        return ($this->rowspan !== null);
    }

    /**
     * @see TableCellElementInterface::setRowspan()
     */
    final public function setRowspan(int $rowspan = null) : TableCellElementInterface
    {
        if ($this->rowspan !== $rowspan) {
            $this->rowspan = $rowspan;
            $this->setChanged(true);
        }
        return $this;
    }

    /**
     * @var Th[]
     */
    private $headers = [];

    /**
     * @see TableCellElementInterface::getHeaders()
     */
    final public function getHeaders() : array
    {
        return $this->headers;
    }

    /**
     * @see TableCellElementInterface::addHeader()
     */
    final public function addHeader(Th $header) : TableCellElementInterface
    {
        if (!\in_array($header, $this->headers, true)) {
            $header->needID();
            $this->headers[] = $header;
            $this->setChanged(true);
        }
        return $this;
    }

    /**
     * @see TableCellElementInterface::delHeader()
     */
    final public function delHeader(Th $header) : TableCellElementInterface
    {
        $key = \array_search($header, $this->headers, true);
        if ($key === false) {
            throw new \InvalidArgumentException("Can not remove header reference that did not exist!");
        }
        unset($this->headers[$key]);
        $this->headers = \array_values($this->headers);
        $this->setChanged(true);

        return $this;
    }

    /**
     * Set or clear the headers for this cell, replacing the actual list
     *
     * @return static $this
     */
    final public function setHeaders(Th ...$headers) : TableCellElementInterface
    {
        if ($this->headers !== $headers) {
            $this->headers = $headers;
            $this->setChanged(true);
        }
        return $this;
    }

    protected function renderAttributes() : string
    {
        return parent::renderAttributes()
            . Util::renderHtmlAttribute('colspan', $this->colspan)
            . Util::renderHtmlAttribute('rowspan', $this->rowspan)
        ;
    }
}
