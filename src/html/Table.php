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
 * @link http://www.w3.org/TR/html5/tabular-data.html#the-table-element
 */
class Table implements WidgetInterface {
	use WidgetTrait;
	
	/**
	 * @var TableHeader
	 */
	private $header;
	
	public function getHeader() {
		return $this->header;
	}
	
	public function setHeader(TableHeader $newHeader) {
		$this->header = $newHeader;
		return $this;
	}
	
	/**
	 * @var TableFooter
	 */
	private $footer;
	
	public function getFooter() {
		return $this->footer;
	}
	
	public function setFooter(TableFooter $newFooter) {
		$this->footer = $newFooter;
		return $this;
	}
	
	/**
	 * @var \nexxes\widgets\WidgetCollection
	 */
	private $bodies;
	
	public function bodies() {
		if (is_null($this->bodies)) {
			$this->bodies = new WidgetCollection($this, false);
		}
		
		return $this->bodies;
	}
	
	public function __toString() {
		$r = '<table' . $this->getAttributesHTML() . '>' . PHP_EOL;

		if (!is_null($this->getHeader())) {
			$r .= $this->getHeader();
		}

		if (!is_null($this->getFooter())) {
			$r .= $this->getFooter();
		}

		foreach ($this->bodies() as $body) {
			$r .= $body;
		}

		$r .= '</table>' . PHP_EOL;
		
		return $r;
	}
}
