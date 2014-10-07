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
