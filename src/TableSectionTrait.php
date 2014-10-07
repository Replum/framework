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
	
	protected function renderTableSection($tag) {
		$r = '<' . $tag . $this->renderAttributes() . '>' . PHP_EOL;
		
		foreach ($this->rows() as $row) {
			$r .= $row;
		}
		
		$r .= '</' . $tag . '>' . PHP_EOL;
		return $r;
	}
}
