<?php

namespace nexxes\widgets;

/**
 * @author Dennis Birkholz <dennis.birkholz@nexxes.net>
 */
trait WidgetCompositeTrait {
	use WidgetTrait;
	
	/**
	 * The real normalized slot definition
	 * @var array
	 */
	private $WidgetCompositeTraitSlots=  [];
	
	/**
	 * The children of this widget, stored by their slot
	 * @var array<\nexxes\widgets\WidgetInterface>
	 */
	private $WidgetCompositeTraitChildren = [];
	
	
	
	
	/**
	 * @implements \nexxes\widgets\WidgetCompositeInterface
	 */
	public function childSlot($name, array $allowedClasses = [ \nexxes\widgets\WidgetInterface::class ]) {
		$this->WidgetCompositeTraitSlots[$name] = $allowedClasses;
	}
	
	/**
	 * @implements \ArrayAccess
	 */
	public function offsetExists($slot) {
		return isset($this->WidgetCompositeTraitChildren[$slot]);
	}
	
	/**
	 * @implements \ArrayAccess
	 */
	public function offsetGet($slot) {
		if (isset($this->WidgetCompositeTraitChildren[$slot])) {
			return $this->WidgetCompositeTraitChildren[$slot];
		}
		
		if (isset($this->WidgetCompositeTraitSlots[$slot])) {
			return null;
		}
		
		throw new \InvalidArgumentException('Access to invalid slot "' . $slot . '"');
	}
	
	/**
	 * @implements \ArrayAccess
	 */
	public function offsetSet($slot, $value) {
		if (!isset($this->WidgetCompositeTraitSlots[$slot])) {
			throw new \InvalidArgumentException('Trying to set invalid slot "' . $slot . '"');
		}
		
		if (isset($this->WidgetCompositeTraitChildren[$slot]) && ($this->WidgetCompositeTraitChildren[$slot] === $value)) {
			return $value;
		}
		
		foreach ($this->WidgetCompositeTraitSlots[$slot] AS $class) {
			if ($value instanceof $class) {
				// FIXME: unset parent of old child
				$this->WidgetCompositeTraitChildren[$slot] = $value;
				$value->setParent($this);
				$this->setChanged(true);
				return $value;
			}
		}
		
		throw new \InvalidArgumentException('Cannot set slot "' . $slot . '", supplied argument does not implement one of the possible classes "' . \implode('", "', $this->WidgetCompositeTraitSlots[$slot]) . '"');
	}
	
	/**
	 * @implements \ArrayAccess
	 */
	public function offsetUnset($slot) {
		if (!isset($this->WidgetCompositeTraitSlots[$slot])) {
			throw new \InvalidArgumentException('Invalid slot "' . $slot . '"');
		}
		
		if (!isset($this->WidgetCompositeTraitChildren[$slot])) {
			return;
		}
		
		// FIXME: unset parent of old child
		unset($this->WidgetCompositeTraitChildren[$slot]);
		$this->setChanged(true);
	}
	
	/**
	 * @implements \IteratorAggregate
	 */
	public function getIterator() {
		return new \ArrayIterator($this->WidgetCompositeTraitChildren);
	}
	
	/**
	 * @implements \Countable
	 */
	public function count() {
		return \count($this->WidgetCompositeTraitChildren);
	}
}
