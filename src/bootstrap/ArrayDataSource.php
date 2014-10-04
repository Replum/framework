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

/**
 * @author Dennis Birkholz <dennis.birkholz@nexxes.net>
 */
class ArrayDataSource implements TableDataSourceInterface {
	public $fields;
	public $data;
	
	public function count($mode = 'COUNT_NORMAL') {
		return \count($this->data);
	}

	public function displayName($fieldName) {
		return $this->fields[$fieldName];
	}

	public function fields() {
		return \array_keys($this->fields);
	}

	public function ids() {
		return \array_keys($this->data);
	}

	public function isSortable($fieldName) {
		return true;
	}

	public function value($id, $fieldName) {
		return $this->data[$id][$fieldName];
	}
}
