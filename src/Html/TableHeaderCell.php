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

use \Replum\WidgetContainerInterface;
use \Replum\WidgetContainerTrait;

/**
 * @author Dennis Birkholz <dennis@birkholz.org>
 * @link http://www.w3.org/TR/html5/tabular-data.html#the-th-element
 */
class TableHeaderCell implements WidgetContainerInterface, TableCellInterface
{
    use WidgetContainerTrait,
        TableCellTrait;

    public function __toString()
    {
        return '<th ' . $this->renderAttributes() . '>' . $this->renderChildren() . '</th>' . PHP_EOL;
    }

    protected function renderAttributes()
    {
        return
        $this->renderWidgetAttributes()
        . $this->renderTableCellAttributes()
        ;
    }
}
