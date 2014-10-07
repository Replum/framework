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

use \nexxes\widgets\WidgetContainerInterface;
use \nexxes\widgets\WidgetContainerTrait;

/**
 * @author Dennis Birkholz <dennis.birkholz@nexxes.net>
 * @link http://www.w3.org/TR/html5/tabular-data.html#the-td-element
 */
class TableDataCell implements WidgetContainerInterface, TableCellInterface {
	use WidgetContainerTrait, TableCellTrait;
	
	public function __toString() {
		return '<td ' . $this->renderAttributes() . $this->renderTableCell() . '>' . $this->renderChildren() . '</td>' . PHP_EOL;
	}
}
