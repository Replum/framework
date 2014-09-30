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
	 */
	public function register(WidgetInterface $widget) {
		if ($widget->hasID()) {
			$newID = $widget->getID();
		} else {
			$newID = $this->generateId();
		}
		
		// Check no other widget has ID
		if ($this->hasWidget($newID)) {
			if ($this->widgets[$newID] !== $widget) {
				throw new \InvalidArgumentException('The supplied widget ID "' . $newID . '" is already used by another widget!');
			}
			// Nothing changed
			return;
		}
		
		// Cleanup old mapping
		if (false !== ($oldID = \array_search($widget, $this->widgets, true))) {
			unset($this->widgets[$oldID]);
		}
		
		$this->widgets[$newID] = $widget;
		$widget->setID($newID, true);
	}
	
	/**
	 * Generate a new random ID that is not associated to a widget yet.
	 * 
	 * @param int $length
	 */
	public function generateId($length = 5) {
		$newID = 'w_' . (new RandomString($length));
		
		if (!$this->hasWidget($newID)) {
			return $newID;
		}
		
		// If new ID is not unique, create a new one that is one char longer
		return $this->generateId($length + 1);
	}
	
	/**
	 * Check whether a widget exists for the supplied ID
	 * 
	 * @param string $id
	 * @return boolean
	 */
	public function hasWidget($id) {
		return isset($this->widgets[$id]);
	}
	
	/**
	 * Get a widget from the registry or load it from apc cache if not already loaded
	 * 
	 * @param string $id
	 * @return \nexxes\widgets\WidgetInterface
	 */
	public function getWidget($id) {
		if (!$this->hasWidget($id)) {
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
