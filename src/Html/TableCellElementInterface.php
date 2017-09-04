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

/**
 * @author Dennis Birkholz <dennis@birkholz.org>
 * @link https://www.w3.org/TR/html5/tabular-data.html#attributes-common-to-td-and-th-elements
 */
interface TableCellElementInterface
{
    /**
     * Get the number of columns that the cell is to span
     */
    function getColspan() : int;

    /**
     * Check whether the number of columns that the cell is to span is set
     */
    function hasColspan() : bool;

    /**
     * Set or clear the number of columns that the cell is to span
     *
     * @return static $this
     */
    function setColspan(int $colspan = null) : self;

    /**
     * Get the number of rows that the cell is to span
     */
    function getRowspan() : int;

    /**
     * Check whether the number of rows that the cell is to span is set
     */
    function hasRowspan() : bool;

    /**
     * Set or clear the number of rows that the cell is to span
     *
     * @return static $this
     */
    function setRowspan(int $rowspan = null) : self;

    /**
     * Get the headers for this cell
     *
     * @return Th[]
     */
    function getHeaders() : array;

    /**
     * Add a header to the list of headers for this cell
     *
     * @return static $this
     */
    function addHeader(Th $header) : self;

    /**
     * Del a header from the list of headers for this cell
     *
     * @return static $this
     */
    function delHeader(Th $header) : self;

    /**
     * Set or clear the headers for this cell, replacing the actual list
     *
     * @return static $this
     */
    function setHeaders(Th ...$headers) : self;
}
