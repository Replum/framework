<?php

namespace nexxes\widgets;

trait WidgetContainerTrait {
	/**
	 * The children of this widget, stored by their slot
	 * @var array<\nexxes\widgets\WidgetInterface>
	 */
	private $_trait_WidgetContainer_children = [];
	
	
	
	
	/**
	 * @implements \ArrayAccess
	 */
	public function offsetExists($offset) {
		return isset($this->_trait_WidgetContainer_children[$offset]);
	}
	
	/**
	 * @implements \ArrayAccess
	 */
	public function offsetGet($offset) {
		if (isset($this->_trait_WidgetContainer_children[$offset])) {
			return $this->_trait_WidgetContainer_children[$offset];
		}
		
		throw new \InvalidArgumentException('Can not access widget with undefined offset "' . $offset . '"');
	}
	
	/**
	 * @implements \ArrayAccess
	 */
	public function offsetSet($offset, $value) {
		if (!($value instanceof \nexxes\widgets\WidgetInterface)) {
			throw new \InvalidArgumentException('A widget container can only contain contain elements implementing the ' . \nexxes\widgets\interfaces\Widget::class . ' interface');
		}
		
		// Get next offset for append [] operation
		if (\is_null($offset)) {
			$offset = \count($this->_trait_WidgetContainer_children);
		}
		
		// No change here
		if (isset($this->_trait_WidgetContainer_children[$offset]) && ($this->_trait_WidgetContainer_children[$offset] === $value)) {
			return;
		}
		
		if (!\is_int($offset)) {
			throw new \InvalidArgumentException('Invalid list element "' . $offset . '", only numerical keys allowed!');
		}
		
		if ($offset < 0) {
			throw new \InvalidArgumentException('Invalid list element "' . $offset . '"');
		}
		
		if (!isset($this->_trait_WidgetContainer_children[$offset]) && ($offset > \count($this->_trait_WidgetContainer_children))) {
			throw new \InvalidArgumentException('No sparse list allowed, use append operation to avoid holes!');
		}
		
		$this->_trait_WidgetContainer_children[$offset] = $value;
		$value->setParent($this);
		
		return $value;
	}
	
	/**
	 * @implements \ArrayAccess
	 */
	public function offsetUnset($offset) {
		if (!isset($this->_trait_WidgetContainer_children[$offset])) {
			throw new \InvalidArgumentException('Invalid offset "' . $offset . '"');
		}
		
		unset($this->_trait_WidgetContainer_children[$offset]);
		$this->_trait_WidgetContainer_children = \array_values($this->_trait_WidgetContainer_children);
	}
	
	/**
	 * @implements \IteratorAggregate
	 */
	public function getIterator() {
		return new \ArrayIterator($this->_trait_WidgetContainer_children);
	}
	
	/**
	 * @implements \Countable
	 */
	public function count() {
		return \count($this->_trait_WidgetContainer_children);
	}
	
	/**
	 * @implements \nexxes\widgets\WidgetContainerInterface
	 */
	public function hasChild(\nexxes\widgets\WidgetInterface $widget) {
		return \in_array($widget, $this->_trait_WidgetContainer_children, true);
	}
}
