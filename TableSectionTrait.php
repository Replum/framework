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

use \nexxes\widgets\WidgetCollection;

/**
 * @author Dennis Birkholz <dennis.birkholz@nexxes.net>
 * @link http://www.w3.org/TR/html5/tabular-data.html#htmltablesectionelement
 */
trait TableSectionTrait {
	/**
	 * @var WidgetCollection
	 */
	private $TableSectionTraitRows;
	
	/**
	 * @implements TableSectionInterface
	 * {@inheritdoc}
	 */
	public function rows() {
		if (is_null($this->TableSectionTraitRows)) {
			$this->TableSectionTraitRows = new WidgetCollection($this, false);
		}
		
		return $this->TableSectionTraitRows;
	}
	
	protected function renderTableSectionHTML($tag) {
		$r = '<' . $tag . $this->getAttributesHTML() . '>' . PHP_EOL;
		
		foreach ($this->rows() as $row) {
			$r .= $row;
		}
		
		$r .= '</' . $tag . '>' . PHP_EOL;
		return $r;
	}
}
