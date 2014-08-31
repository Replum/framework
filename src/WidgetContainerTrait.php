<?php

namespace nexxes\widgets;

trait WidgetContainerTrait {
	/**
	 * The children of this widget, stored by their slot
	 * @var array<\nexxes\widgets\WidgetInterface>
	 */
	private $WidgetContainerTraitChildren = [];
	
	
	
	
	/**
	 * @implements \ArrayAccess
	 */
	public function offsetExists($offset) {
		return isset($this->WidgetContainerTraitChildren[$offset]);
	}
	
	/**
	 * @implements \ArrayAccess
	 */
	public function offsetGet($offset) {
		if (isset($this->WidgetContainerTraitChildren[$offset])) {
			return $this->WidgetContainerTraitChildren[$offset];
		}
		
		throw new \InvalidArgumentException('Can not access widget with undefined offset "' . $offset . '"');
	}
	
	/**
	 * @implements \ArrayAccess
	 * @uses WidgetContainerTrait::validateWidget Extension point for custom value restrictions.
	 */
	public function offsetSet($offset, $value) {
		$this->validateWidget($value);
		
		// Get next offset for append [] operation
		if (\is_null($offset)) {
			$offset = \count($this->WidgetContainerTraitChildren);
		}
		
		// No change here
		if (isset($this->WidgetContainerTraitChildren[$offset]) && ($this->WidgetContainerTraitChildren[$offset] === $value)) {
			return;
		}
		
		if (!\is_int($offset)) {
			throw new \InvalidArgumentException('Invalid list element "' . $offset . '", only numerical keys allowed!');
		}
		
		if ($offset < 0) {
			throw new \InvalidArgumentException('Invalid list element "' . $offset . '"');
		}
		
		if (!isset($this->WidgetContainerTraitChildren[$offset]) && ($offset > \count($this->WidgetContainerTraitChildren))) {
			throw new \InvalidArgumentException('No sparse list allowed, use append operation to avoid holes!');
		}
		
		if (!in_array($value, $this->WidgetContainerTraitChildren)) {
			$this->WidgetContainerTraitChildren[$offset] = $value;
			$value->setParent($this);
		}
		
		return $value;
	}
	
	/**
	 * @implements \ArrayAccess
	 */
	public function offsetUnset($offset) {
		if (!isset($this->WidgetContainerTraitChildren[$offset])) {
			throw new \InvalidArgumentException('Invalid offset "' . $offset . '"');
		}
		
		unset($this->WidgetContainerTraitChildren[$offset]);
		$this->WidgetContainerTraitChildren = \array_values($this->WidgetContainerTraitChildren);
	}
	
	/**
	 * @implements \IteratorAggregate
	 */
	public function getIterator() {
		return new \ArrayIterator($this->WidgetContainerTraitChildren);
	}
	
	/**
	 * @implements \Countable
	 */
	public function count() {
		return \count($this->WidgetContainerTraitChildren);
	}
	
	/**
	 * @implements \nexxes\widgets\WidgetContainerInterface
	 */
	public function hasChild(\nexxes\widgets\WidgetInterface $widget) {
		return \in_array($widget, $this->WidgetContainerTraitChildren, true);
	}
	
	/**
	 * This method is used by the trait to determine if an object qualifies as a new child in this WidgetContainer.
	 * If a specialised WidgetContainer should apply stricter rules, overwrite this method.
	 * 
	 * This method must throw an exception if a required rules is violated.
	 * 
	 * @param mixed $widget
	 * @throws \InvalidArgumentException
	 */
	protected function validateWidget($widget) {
		if (!($widget instanceof WidgetInterface)) {
			throw new \InvalidArgumentException('A widget container can only contain elements implementing the ' . WidgetInterface::class . ' interface');
		}
	}
}
