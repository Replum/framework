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

use \nexxes\widgets\events\WidgetReplaceEvent;
use \nexxes\widgets\events\WidgetRemoveEvent;

/**
 * The WidgetCollection represents a set of widgets.
 * 
 * The elements are numbered from 0 to count-1 and can be accessed using Array
 *  access with numerical indexes.
 * 
 * When an element is removed, the collection is reindexed, so avoid using
 *  the index when iterating over the collection.
 * 
 * The elements can also be accessed using Array access with string indexes.
 *  The supplied string index is matched against the ID and name attribute
 *  (if present) of the widgets.
 * 
 * If the WidgetCollection represents the list of children of a WidgetContainer,
 *  the widgets are ordered in "tree" order.
 * 
 * If the WidgetCollection represents a partial/filtered subset of the list of
 *  descendants of the owner of the WidgetCollection, then the order of the
 *  elements is not fixed. It may represent any order, e.g. the order in which
 *  the elements where added to the tree (and not the tree order).
 *
 * @author Dennis Birkholz <dennis.birkholz@nexxes.net>
 * @link http://www.w3.org/TR/dom/#htmlcollection
 */
class WidgetCollection implements \ArrayAccess, \Countable, \IteratorAggregate {
	/**
	 * @var WidgetInterface
	 */
	private $owner;
	
	/**
	 * @var array<WidgetInterface>
	 */
	private $widgets = [];
	
	/**
	 * An auxiliary WidgetCollection just holds other widgets without maintaining their
	 *  parent and without issuing lifecycle events.
	 * 
	 * @var boolean
	 */
	private $auxiliary = false;
	
	
	
	
	/**
	 * @param WidgetInterface $owner
	 * @param boolean $auxiliary
	 */
	public function __construct(WidgetInterface $owner, $auxiliary = true) {
		$this->owner = $owner;
		$this->auxiliary = $auxiliary;
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
	
	
	private function getWidgetByIdOrName($name) {
		foreach ($this->widgets as $widget) {
			/* @var $widget WidgetInterface */
			if ($widget->hasID() && ($widget->getID() == $name)) {
				return $widget;
			}

			if (\method_exists($widget, 'getName') && ($widget->getName() == $name)) {
				return $widget;
			}
		}

		return false;
	}
	
	/**
	 * @implements \ArrayAccess
	 * @return boolean
	 */
	public function offsetExists($offset) {
		if (\is_int($offset)) {
			return isset($this->widgets[$offset]);
		}
		
		return ($this->getWidgetByIdOrName($offset) !== false);
	}
	
	/**
	 * @implements \ArrayAccess
	 * @return WidgetInterface
	 */
	public function offsetGet($offset) {
		if (\is_int($offset)) {
			if (!isset($this->widgets[$offset])) {
				throw new \InvalidArgumentException('No widget exists with offset "' . $offset . '"');
			}
			
			return $this->widgets[$offset];
		}
		
		if (false !== ($widget = $this->getWidgetByIdOrName($offset))) {
			return $widget;
		} else {
			throw new \InvalidArgumentException('No widget exists with id/name "' . $offset . '"');
		}
	}
	
	/**
	 * @implements \ArrayAccess
	 * @param string $offset
	 * @param WidgetInterface $widget
	 * @return WidgetInterface
	 */
	public function offsetSet($offset, $widget) {
		if (is_null($offset)) {
			return $this->add($widget);
		}
		
		if (!\is_int($offset) || ($offset < 0) || (count($this->widgets)-1 < $offset)) {
			throw new \InvalidArgumentException('Can only set widgets with index from 0 to count-1, "' . $offset . '" is illegal!');
		}
		
		return $this->replace($this->widgets[$offset], $widget);
	}
	
	/**
	 * @implements \ArrayAccess
	 */
	public function offsetUnset($offset) {
		if (isset($this->widgets[$offset])) {
			$this->remove($this->widgets[$offset]);
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
	
	/**
	 * Add (append) the widget to the collection.
	 * If the widget already exists in the collection, do nothing.
	 * 
	 * @param WidgetInterface $widget
	 * @return WidgetCollection $this for chaining
	 */
	public function add(WidgetInterface $widget) {
		if ($this->contains($widget)) {
			return $this;
		}
		
		if (!$this->auxiliary) {
			// Remove widget from previous owner first
			if (!$widget->isRoot() && ($widget->getParent() instanceof WidgetContainerInterface)) {
				$widget->getParent()->children()->remove($widget);
			}
		}
		
		$this->widgets[] = $widget;
		
		if (!$this->auxiliary) {
			$widget->setParent($this->owner);
		}
		
		return $this;
	}
	
	/**
	 * Remove the supplied widget from the collection if it is part of the collection.
	 * 
	 * @param WidgetInterface $widget
	 * @return WidgetCollection $this for chaining
	 */
	public function remove(WidgetInterface $widget) {
		if (!$this->contains($widget)) {
			return $this;
		}
		
		$key = $this->find($widget);
		unset($this->widgets[$key]);
		
		if (!$this->auxiliary) {
			$widget->clearParent();
		}
		
		$this->reindex();
		
		return $this;
	}
	
	/**
	 * 
	 * @param WidgetInterface $oldWidget
	 * @param WidgetInterface $newWidget
	 * @return WidgetCollection $this for chaining
	 */
	public function replace(WidgetInterface $oldWidget, WidgetInterface $newWidget) {
		if (false === ($key = $this->find($oldWidget))) {
			throw new \InvalidArgumentException('Can not replace widget that is not in collection!');
		}
		
		if (!$this->auxiliary) {
			$this->owner->dispatch(new WidgetRemoveEvent($this->owner, $oldWidget));
		}
		
		$this->widgets[$key] = $newWidget;
		
		if (!$this->auxiliary) {
			$this->owner->dispatch(new WidgetReplaceEvent($this->owner, $oldWidget, $newWidget));
			$newWidget->setParent($this->owner);
		}
		
		return $this;
	}
	
	/**
	 * Clean collection of all contained elements
	 */
	public function blank() {
		foreach ($this->widgets as $widget) {
			$this->remove($widget);
		}
	}
}
