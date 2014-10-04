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

/**
 * Default implementation of the TableCellInterface
 * 
 * @author Dennis Birkholz <dennis.birkholz@nexxes.net>
 */
trait TableCellTrait {
	/**
	 * @var int
	 */
	private $TableCellTraitColSpan = 1;
	
	/**
	 * @implements TableCellInterface
	 * {@inheritdoc}
	 */
	public function getColSpan() {
		return $this->TableCellTraitColSpan;
	}
	
	/**
	 * @implements TableCellInterface
	 * {@inheritdoc}
	 */
	public function setColSpan($newColSpan) {
		if (!\is_int($newColSpan)) {
			throw new \InvalidArgumentException('Colspan must be an integer.');
		}
		
		if ($newColSpan < 1) {
			throw new \InvalidArgumentException('Colspan must be an integer >= 1.');
		}
		
		$this->TableCellTraitColSpan = (int)$newColSpan;
		return $this;
	}
	
	
	/**
	 * @var int
	 */
	private $TableCellTraitRowSpan = 1;
	
	/**
	 * @implements TableCellInterface
	 * {@inheritdoc}
	 */
	public function getRowSpan() {
		return $this->TableCellTraitRowSpan;
	}
	
	/**
	 * @implements TableCellInterface
	 * {@inheritdoc}
	 */
	public function setRowSpan($newRowSpan) {
		if (!\is_int($newRowSpan)) {
			throw new \InvalidArgumentException('Colspan must be an integer.');
		}
		
		if ($newRowSpan < 1) {
			throw new \InvalidArgumentException('Colspan must be an integer >= 1.');
		}
		
		$this->TableCellTraitRowSpan = (int)$newRowSpan;
		return $this;
	}
	
	
	protected function renderTableCellHTML() {
		return ($this->getColSpan() > 1 ? ' colspan=' . $this->getColSpan() : '')
			. ($this->getRowSpan() > 1 ? ' rowspan=' . $this->getRowSpan() : '');
	}
}
