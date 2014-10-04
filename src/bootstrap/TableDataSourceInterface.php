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
 * A bootstrap table reads all its data from a datasource.
 * 
 * @author Dennis Birkholz <dennis.birkholz@nexxes.net>
 */
interface TableDataSourceInterface extends \Countable {
	/**
	 * Check whether a field is sortable
	 * @param string $fieldName
	 * @return boolean
	 */
	function isSortable($fieldName);
	
	/**
	 * Get the list of available fields
	 * @return array<string>
	 */
	function fields();
	
	/**
	 * Get the (translated) name to show for a field
	 * 
	 * @param string $fieldName
	 * @return string
	 */
	function displayName($fieldName);
	
	/**
	 * Get the (translated) value to display
	 * 
	 * @return string|WidgetInterface
	 */
	function value($id, $fieldName);
	
	/**
	 * Get the list of IDs of the entries to show on the current page, in that order.
	 * 
	 * @return array<mixed>
	 */
	function ids();
}
