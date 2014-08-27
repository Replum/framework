<?php

namespace nexxes\widgets;

use \nexxes\common\RandomString;

/**
 * The widget registry class holds references to all widgets that can be accessed by id
 */
class WidgetRegistry implements \IteratorAggregate {
	/**
	 * A list of all registered widgets
	 * 
	 * @var array<WidgetInterface>
	 */
	private $widgets = [];
	
	
	
	
	/**
	 * Generate a unique identifier to use in a widget and register the widget
	 * 
	 * @return string
	 */
	public function register(IdentifiableInterface $widget, $length = 5) {
		$newID = 'w_' . (new RandomString($length));
		
		// If new ID is not unique, create a new one that is one char longer
		if (isset($this->widgets[$newID])) {
			return $this->register($widget, $length + 1);
		}
		
		$this->widgets[$newID] = $widget;
		$widget->setID($newID);
		return $newID;
	}
	
	/**
	 * Notify the registry that the ID of a widget was changed
	 * 
	 * @param IdentifiableInterface $widget
	 */
	public function notifyIdChange(IdentifiableInterface $widget) {
		$oldID = \array_search($widget, $this->widgets, true);
		
		if (!$oldID) {
			throw new \InvalidArgumentException('The supplied widget has not been registered yet!');
		}
		
		// ID unchanged, nothing to do
		if ($oldID === $widget->getID()) {
			return;
		}
		
		if (isset($this->widgets[$widget->getID()]) && ($this->widgets[$widget->getID()] !== $widget)) {
			throw new \InvalidArgumentException('The supplied widget ID "' . $widget->getID() . '" is already used by another widget!');
		}
		
		unset($this->widgets[$oldID]);
		$this->widgets[$widget->getID()] = $widget;
	}
	
	/**
	 * Get a widget from the registry or load it from apc cache if not already loaded
	 * 
	 * @param string $id
	 * @return IdentifiableInterface
	 */
	public function getWidget($id) {
		if (!isset($this->widgets[$id])) {
			throw new \InvalidArgumentException('Unknown widget with id "' . $id . '"');
		}
		
		return $this->widgets[$id];
	}
	
	/**
	 * Allow to iterate over all widgets
	 * @return \ArrayIterator
	 */
	public function getIterator() {
		return new \ArrayIterator($this->widgets);
	}
}
