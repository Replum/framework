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
use \nexxes\widgets\WidgetHasDoubleClickEventInterface;
use \nexxes\widgets\WidgetHasDoubleClickEventTrait;

/**
 * @author Dennis Birkholz <dennis.birkholz@nexxes.net>
 * @link http://www.w3.org/TR/html5/tabular-data.html#the-td-element
 */
class TableDataCell implements WidgetContainerInterface, TableCellInterface, WidgetHasDoubleClickEventInterface {
	use WidgetContainerTrait, TableCellTrait, WidgetHasDoubleClickEventTrait;
	
	public function __toString() {
		return '<td ' . $this->renderAttributes() . '>' . $this->renderChildren() . '</td>' . PHP_EOL;
	}
	
	protected function renderAttributes() {
		return
			$this->renderWidgetAttributes()
			. $this->renderTableCellAttributes()
		;
	}
}
