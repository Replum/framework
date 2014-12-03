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

namespace nexxes\widgets\events;

use \nexxes\widgets\WidgetInterface;

/**
 * Event dispatched when a Widget is changed the first time after page creation or after restoring the page in a sub request.
 * 
 * @author Dennis Birkholz <dennis.birkholz@nexxes.net>
 */
class WidgetChangeEvent extends WidgetEvent {
	/**
	 * The name of the changed property of the widget
	 * @var string
	 */
	public $property;
	
	/**
	 * @var mixed
	 */
	public $oldValue;
	
	/**
	 * @var mixed
	 */
	public $newValue;
	
	/**
	 * @param WidgetInterface $widget
	 * @param string $property
	 * @param mixed $oldValue
	 * @param mixed $newValue
	 */
	public function __construct(WidgetInterface $widget, $property = null, $oldValue = null, $newValue = null) {
		parent::__construct($widget);
		$this->property = $property;
		$this->oldValue = $oldValue;
		$this->newValue = $newValue;
	}
}
