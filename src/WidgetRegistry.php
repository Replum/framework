<?php

namespace nexxes\widgets;

/**
 * The widget registry class holds references to all widgets that can be accessed by id
 */
class WidgetRegistry {
	/**
	 * A list of all registered widgets
	 * 
	 * @var array<interfaces\Widget>
	 */
	protected $widgets = [];
	
	
	
	
	/**
	 * Generate a unique identifier to use in a widget and register the widget
	 * 
	 * @return string
	 */
	public function register(interfaces\Identifiable $widget, $length = 5) {
		$newID = 'w_' . $this->createRandomString($length);
		
		// If new ID is not unique, create a new one that is one char longer
		if (isset($this->widgets[$newID])) {
			return $this->register($widget, $length + 1);
		}
		
		$widget->setID($newID);
		$this->widgets[$newID] = $widget;
		return $newID;
	}
	
	/**
	 * Notify the registry that the ID of a widget was changed
	 * 
	 * @param interfaces\Identifiable $widget
	 */
	public function notifyIdChange(interfaces\Identifiable $widget) {
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
	 * @return interfaces\Identifiable
	 */
	public function getWidget($id) {
		if (!isset($this->widgets[$id])) {
			throw new \InvalidArgumentException('Unknown widget with id "' . $id . '"');
		}
		
		return $this->widgets[$id];
	}
	
	/**
	 * Create a random string from the supplied character pool with the supplied number of chars
	 * 
	 * @param int $length
	 * @param array<char> $chars
	 * @return string
	 */
	private function createRandomString($length = 8, $chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ') {
		$str = '';
		
		for ($i=0; $i<$length; $i++) {
			$str .= $chars[rand(0, \strlen($chars)-1)];
		}
		
		return $str;
	}
}
