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

namespace nexxes\widgets;

use \nexxes\widgets\events\WidgetAddEvent;
use \nexxes\widgets\events\WidgetReplaceEvent;
use \nexxes\widgets\events\WidgetRemoveEvent;

/**
 * Description of DependentWidgetList
 *
 * @author Dennis Birkholz <dennis.birkholz@nexxes.net>
 */
class DependentWidgetList implements \IteratorAggregate, \Countable, \ArrayAccess {
	/**
	 * @var WidgetContainerInterface
	 */
	private $owner;
	
	/**
	 * @var array<WidgetInterface>
	 */
	private $widgets = [];
	
	
	
	
	public function __construct(WidgetContainerInterface $owner) {
		$this->owner = $owner;
	}
	
	
	/**
	 * @implements \Countable
	 */
	public function count($mode = 'COUNT_NORMAL') {
		return \count($this->widgets);
	}
	
	
	/**
	 * @implements \IteratorAggregate
	 */
	public function getIterator() {
		return new \ArrayIterator($this->widgets);
	}
	
	
	/**
	 * @implements \ArrayAccess
	 * @return boolean
	 */
	public function offsetExists($offset) {
		return isset($this->widgets[$offset]);
	}
	
	/**
	 * @implements \ArrayAccess
	 * @return WidgetInterface
	 */
	public function offsetGet($offset) {
		return $this->widgets[$offset];
	}
	
	/**
	 * @implements \ArrayAccess
	 * @param string $offset
	 * @param WidgetInterface $value
	 * @return WidgetInterface
	 */
	public function offsetSet($offset, $value) {
		if ($this->contains($value)) {
			// Nothing changed
			if ($offset === ($foundOffset = $this->find($value))) {
				return $value;
			}
			
			else {
				throw new \InvalidArgumentException("Can not add multiple copies of the same widget: " . $foundOffset);
			}
		}
		
		// Replace
		if (isset($this->widgets[$offset])) {
			$old = $this->widgets[$offset];
			$this->widgets[$offset] = $value;
			$value->setParent($this->owner);
			$this->owner->getPage()->getEventDispatcher()->dispatch(WidgetReplaceEvent::class, new WidgetReplaceEvent($this->owner, $old, $value));
		}
		
		else {
			if (is_null($offset)) {
				$this->widgets[] = $value;
			} else {
				$this->widgets[$offset] = $value;
			}
			
			$value->setParent($this->owner);
			$this->owner->getPage()->getEventDispatcher()->dispatch(WidgetAddEvent::class, new WidgetAddEvent($this->owner, $value));
		}
	}
	
	/**
	 * @implements \ArrayAccess
	 */
	public function offsetUnset($offset) {
		if (isset($this->widgets[$offset])) {
			$old = $this->widgets[$offset];
			$this->owner->getPage()->getEventDispatcher()->dispatch(WidgetRemoveEvent::class, new WidgetRemoveEvent($this->owner, $old));
			unset($this->widgets[$offset]);
			$this->reindex();
		}
	}
	
	
	/**
	 * @param WidgetInterface $widget
	 * @return boolean
	 */
	public function contains(WidgetInterface $widget) {
		return \in_array($widget, $this->widgets, true);
	}
	
	/**
	 * Get the index of the widget if it is contained, FALSE otherwise
	 * @param \nexxes\widgets\WidgetInterface $widget
	 * @return mixed
	 */
	public function find(WidgetInterface $widget) {
		return \array_search($widget, $this->widgets, true);
	}
	
	/**
	 * Re-index the widget list to avoid holes in the numbering.
	 * @return DependentWidgetList $this for chaining
	 */
	public function reindex() {
		$this->widgets = \array_values($this->widgets);
		return $this;
	}
}
