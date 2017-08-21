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
 * @link http://www.w3.org/TR/html5/tabular-data.html#htmltablecellelement
 */
interface TableCellInterface
{
    /**
     * @return int
     * @link http://www.w3.org/TR/html5/tabular-data.html#attr-tdth-colspan
     */
    function getColSpan();

    /**
     * @param int $newColSpan
     * @return TableCellInterface $this for chaining
     * @link http://www.w3.org/TR/html5/tabular-data.html#attr-tdth-colspan
     */
    function setColSpan($newColSpan);

    /**
     * @return int
     * @link http://www.w3.org/TR/html5/tabular-data.html#attr-tdth-rowspan
     */
    function getRowSpan();

    /**
     * @param int $newRowSpan
     * @return TableCellInterface $this for chaining
     * @link http://www.w3.org/TR/html5/tabular-data.html#attr-tdth-rowspan
     */
    function setRowSpan($newRowSpan);
}
