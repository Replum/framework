<?php

/*
 * This file is part of the nexxes/widgets-html package.
 *
 * Copyright (c) Dennis Birkholz, nexxes Informationstechnik GmbH <dennis.birkholz@nexxes.net>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace nexxes\widgets\html;

/**
 * @author Dennis Birkholz <dennis.birkholz@nexxes.net>
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
