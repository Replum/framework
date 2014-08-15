<?php

namespace nexxes\widgets;

trait WidgetCompositeTrait {
	/**
	 * The real normalized slot definition
	 * @var array
	 */
	private $_trait_WidgetComposite_slots = [];
	
	/**
	 * The children of this widget, stored by their slot
	 * @var array<\nexxes\widgets\WidgetInterface>
	 */
	private $_trait_WidgetComposite_children = [];
	
	
	
	
	/**
	 * @implements \nexxes\widgets\WidgetCompositeInterface
	 */
	public function childSlot($name, array $allowedClasses = [ \nexxes\widgets\WidgetInterface::class ]) {
		$this->_trait_WidgetComposite_slots[$name] = $allowedClasses;
	}
	
	/**
	 * @implements \ArrayAccess
	 */
	public function offsetExists($slot) {
		return isset($this->_trait_WidgetComposite_children[$slot]);
	}
	
	/**
	 * @implements \ArrayAccess
	 */
	public function offsetGet($slot) {
		if (isset($this->_trait_WidgetComposite_children[$slot])) {
			return $this->_trait_WidgetComposite_children[$slot];
		}
		
		if (isset($this->_trait_WidgetComposite_slots[$slot])) {
			return null;
		}
		
		throw new \InvalidArgumentException('Access to invalid slot "' . $slot . '"');
	}
	
	/**
	 * @implements \ArrayAccess
	 */
	public function offsetSet($slot, $value) {
		if (!isset($this->_trait_WidgetComposite_slots[$slot])) {
			throw new \InvalidArgumentException('Trying to set invalid slot "' . $slot . '"');
		}
		
		if (isset($this->_trait_WidgetComposite_children[$slot]) && ($this->_trait_WidgetComposite_children[$slot] === $value)) {
			return $value;
		}
		
		foreach ($this->_trait_WidgetComposite_slots[$slot] AS $class) {
			if ($value instanceof $class) {
				// FIXME: unset parent of old child
				$this->_trait_WidgetComposite_children[$slot] = $value;
				$value->setParent($this);
				$this->setChanged(true);
				return $value;
			}
		}
		
		throw new \InvalidArgumentException('Cannot set slot "' . $slot . '", supplied argument does not implement one of the possible classes "' . \implode('", "', $this->_trait_WidgetComposite_slots[$slot]) . '"');
	}
	
	/**
	 * @implements \ArrayAccess
	 */
	public function offsetUnset($slot) {
		if (!isset($this->_trait_WidgetComposite_slots[$slot])) {
			throw new \InvalidArgumentException('Invalid slot "' . $slot . '"');
		}
		
		if (!isset($this->_trait_WidgetComposite_children[$slot])) {
			return;
		}
		
		// FIXME: unset parent of old child
		unset($this->_trait_WidgetComposite_children[$slot]);
		$this->setChanged(true);
	}
	
	/**
	 * @implements \IteratorAggregate
	 */
	public function getIterator() {
		return new \ArrayIterator($this->_trait_WidgetComposite_children);
	}
	
	/**
	 * @implements \Countable
	 */
	public function count() {
		return \count($this->_trait_WidgetComposite_children);
	}
}
