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

namespace nexxes\widgets\bootstrap;

use \nexxes\widgets\WidgetInterface;
use \nexxes\widgets\WidgetTrait;

use \nexxes\widgets\html\A;
use \nexxes\widgets\html\Table as HTMLTable;
use \nexxes\widgets\html\TableHeader;
use \nexxes\widgets\html\TableBody;
use \nexxes\widgets\html\TableFooter;
use \nexxes\widgets\html\TableRow;
use \nexxes\widgets\html\TableHeaderCell;
use \nexxes\widgets\html\TableDataCell;
use \nexxes\widgets\html\Text;

/**
 * @author Dennis Birkholz <dennis.birkholz@nexxes.net>
 */
class Table implements WidgetInterface {
	use WidgetTrait;
	
	/**
	 * @var TableDataSourceInterface
	 */
	public $datasource;
	
	/**
	 * The actual table
	 * @var \nexxes\widgets\html\Table
	 */
	private $table;
	
	/**
	 * @var \nexxes\widgets\html\TableHeader
	 */
	private $header;
	
	/**
	 * @var \nexxes\widgets\html\TableBody
	 */
	private $body;
	
	/**
	 * @var \nexxes\widgets\html\TableFooter
	 */
	private $footer;
	
	
	protected function updateTable() {
		if (is_null($this->table)) {
			$this->table = new HTMLTable($this);
			$this->header = new TableHeader($this->table);
			$this->table->setHeader($this->header);
			$this->body = new TableBody($this->table);
			$this->table->bodies()->add($this->body);
			$this->footer = new TableFooter($this->table);
			$this->table->setFooter($this->footer);
		}
		
		// Build the header
		$this->header->rows()->add($headerRow = new TableRow($this->header));
		foreach ($this->datasource->fields() as $fieldName) {
			$headerRow->cells()->add($cell = new TableHeaderCell($headerRow));
			$text = (new Text())->setText($this->datasource->displayName($fieldName));
			
			if ($this->datasource->isSortable($fieldName)) {
				$link = new A($cell);
				$link->children()->add($text);
				$link->getID();
				$link->onClick([$this, 'sortHandler']);
				
			} else {
				$cell->children()->add($text);
			}
		}
		
		// Build the data cells
		foreach ($this->datasource->ids() as $id) {
			$this->body->rows()->add($row = new TableRow($this->body));
			
			foreach ($this->datasource->fields() as $fieldName) {
				$row->cells()->add($cell = new TableDataCell($row));
				
				$value = $this->datasource->value($id, $fieldName);
				if ($value instanceof WidgetInterface) {
					$cell->children()->add($value);
				} else {
					(new Text($cell))->setText((string)$value);
				}
			}
		}
		
	}
	
	public function __toString() {
		try {
		$this->updateTable();
		
		$this->table->addClass('table');
		$this->table->addClass('table-striped');
		$this->table->addClass('table-bordered');
		$this->table->addClass('table-hover');
		$this->table->addClass('table-condensed');
		
		return (string)$this->table;
		} catch (\Exception $e) {
			echo $e;
		}
	}
	
	/**
	 * Registered as the event handler for the sort event clicks
	 */
	public function sortHandler() {
		throw new \RuntimeException("Handler called!");
	}
}
