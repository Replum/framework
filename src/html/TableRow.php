<?php

/*
 * This file is part of the nexxes/widgets package.
 *
 * Copyright (C) 2014 Dennis Birkholz <dennis.birkholz@nexxes.net>.
 *
 * This library is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Lesser General Public License as
 * published by the Free Software Foundation, either version 3 of
 * the License, or (at your option) any later version.
 *
 * This library is distributed in the hope that it will be useful, but
 * WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 * See the GNU Lesser General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public
 * License along with this library; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston,
 * MA 02110-1301  USA
 */

namespace nexxes\widgets\html;

use \nexxes\widgets\WidgetInterface;
use \nexxes\widgets\WidgetTrait;
use \nexxes\widgets\WidgetCollection;

/**
 * @author Dennis Birkholz <dennis.birkholz@nexxes.net>
 * @link http://www.w3.org/TR/html5/tabular-data.html#the-tr-element
 */
class TableRow implements WidgetInterface {
	use WidgetTrait;
	
	/**
	 * @var WidgetCollection
	 */
	private $cells;
	
	/**
	 * @return WidgetCollection
	 */
	public function cells() {
		if (is_null($this->cells)) {
			$this->cells = new WidgetCollection($this, false);
		}
		
		return $this->cells;
	}
	
	public function __toString() {
		$r = '<tr' . $this->renderAttributes() . '>' . PHP_EOL;
		
		foreach ($this->cells() as $cell) {
			$r .= $cell;
		}
		
		$r .= '</tr>' . PHP_EOL;
		return $r;
	}
}
