<?php

namespace nexxes\widgets;

/**
 * @author Dennis Birkholz <dennis.birkholz@nexxes.net>
 */
trait WidgetContainerTrait {
	use WidgetTrait;
	
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
	
	/**
	 * Simple helper to iterate over all children and render them.
	 * @return string
	 */
	protected function renderChildrenHTML() {
		$r = '';
		
		foreach ($this->WidgetContainerTraitChildren AS $child) {
			$r .= $child . PHP_EOL;
		}
		
		return $r;
	}
	
	
	/**
	 * @implements \nexxes\widgets\WidgetInterface
	 */
	public function getDescendants($filterByType = null) {
		$descendants = [];
		
		foreach ($this AS $child) {
			if (is_null($filterByType) || ($child instanceof $filterByType)) {
				$descendants[] = $child;
			}
			
			$descendants = \array_merge($descendants, $child->getDescendants($filterByType));
		}
		
		return $descendants;
	}
	
	
	/**
	 * The HTML tag to use for this container, defaults to DIV
	 * @var string
	 */
	private $WidgetContainerTraitType;
	
	/**
	 * Return the HTML tag for this container
	 * 
	 * @return string
	 */
	public function getType() {
		return (
			$this->WidgetContainerTraitType !== null
			? $this->WidgetContainerTraitType
			: (
					$this->validTypes() !== null
					? $this->validTypes()[0]
					: 'div'
				)
		);
	}
	
	/**
	 * Change the used tag for this container
	 * 
	 * @param string $newType
	 * @return \nexxes\widgets\WidgetContainer $this for chaining
	 */
	public function setType($newType) {
		if (($this->validTypes() !== null) && !\in_array($newType, $this->validTypes())) {
			throw new \UnexpectedValueException('Invalid tag "' . $newType . '" for class "' . static::class . '", valid tags are: ' . \implode(', ', $this->validTypes()));
		}
		
		if ($this->WidgetContainerTraitType !== $newType) {
			$this->WidgetContainerTraitType = $newType;
			$this->setChanged(true);
		}
		
		return $this;
	}
	
	/**
	 * @return array<String> List of valid tags nor NULL for no restriction
	 */
	protected function validTypes() {
		return null;
	}
}
