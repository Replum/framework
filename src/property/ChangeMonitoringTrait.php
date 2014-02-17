<?php

namespace nexxes\property;

use \nexxes\PageContext;

/**
 * The trait removes all public properties annotated with a \nexxes\property\Config annotation
 * and handles them internaly so changes can be monitored by the __set() method.
 * 
 * The class using this trait should implement the Serializable interface to make serialization work correctly.
 * Also the _initializeChangeMonitoring() method must be called in the constructor
 */
trait ChangeMonitoringTrait {
	/**
	 * Contains the real values for the properties and a changed flag
	 * 
	 * @var array
	 */
	private $_properties = [];
	
	/**
	 * Mark if any property of this widget changed
	 * 
	 * @var bool
	 */
	private $_changed = false;
	
	
	
	
	/**
	 * Check if the current widget changed
	 * 
	 * @implements \nexxes\iWidget
	 * @return bool
	 */
	public function hasChanged() {
		return $this->_changed;
	}
	
	
	/**
	 * Get changed values for the widget
	 */
	public function getChanges() {
		$changed = [];
		
		foreach ($this->_properties AS $property => $data) {
			if ($data['changed']) {
				$changed[$property] = $data['value'];
			}
		}
		
		return $changed;
	}
	
	
	/**
	 * Initialize the property magic for this widget
	 * All public properties are removed from the object and handled thru __get and __set so all changes can be notified.
	 */
	final protected function _initializeChangeMonitoring() {
		$properties = PageContext::$propertyHandler->getProperties($this);
		
		foreach ($properties AS $property) {
			$this->_properties[$property->name] = [
					'value' => $this->{$property->name},
					'changed' => false,
			];
			
			unset($this->{$property->name});
		}
	}
	
	
	/**
	 * Checks if the supplied property exists for the object
	 * 
	 * @param string $property
	 * @return bool
	 */
	final public function __isset($property) {
		return isset($this->_properties[$property]);
	}
	
	
	/**
	 * Get the value for the specified property
	 * 
	 * @param string $property
	 * @return mixed
	 * @throws \InvalidArgumentException
	 */
	final public function &__get($property) {
		if (!isset($this->_properties[$property])) {
			throw new \InvalidArgumentException('Unknown property "' . $property . '" for object of class "' . \get_class($this) . '"');
		}
		
		return $this->_properties[$property]['value'];
	}
	
	
	/**
	 * Set the property to the specified value
	 * 
	 * @todo Add type checks and setter calls
	 * 
	 * @param string $property
	 * @param mixed $raw
	 * @throws \InvalidArgumentException
	 */
	final public function __set($property, $raw) {
		if (!isset($this->_properties[$property])) {
			throw new \InvalidArgumentException('Unknown property "' . $property . '" for object of class "' . \get_class($this) . '"');
		}
		
		$properties = PageContext::$propertyHandler->getProperties($this);
		$value = $this->sanitizeValue($properties[$property], $raw);
		
		if ($properties[$property]->array && !is_array($value)) {
			$this->_properties[$property]['value'][] = $value;
		} else {
			$this->_properties[$property]['value'] = $value;
		}
		
		$this->_properties[$property]['changed'] = true;
	}
	
	
	/**
	 * Create a restorable string-representation of this widget
	 * Current property values are stored in a default object and that is serialized
	 * 
	 * @return String
	 * @implements \Serializable
	 */
	final public function _SerializeChangeMonitor() {
		$o = new \stdClass();
		
		foreach ($this->_properties AS $property => $data) {
			$o->$property = $data['value'];
		}
		
		foreach (\get_object_vars($this) AS $property => $value) {
			if (($property == '_properties') || ($property == '_changed')) {
				continue;
			}
			
			$o->$property = $this->_SerializeProperty($value);
		}
		
		return \serialize($o);
	}
	
	/**
	 * Helper function to serialize recursive structures
	 */
	final private function _SerializeProperty($value) {
		if ($value instanceof \nexxes\iWidget) {
			return new \nexxes\WidgetIdentifier($value);
		}
		
		elseif (\is_array($value)) {
			$r = [];
			foreach ($value AS $k => $v) {
				$r[$k] = $this->_SerializeProperty($v);
			}
			return $r;
		}
		
		else {
			return $value;
		}
	}
	
	/**
	 * Unserialize the data from the supplied object into the current widget
	 * 
	 * @param String $serialized
	 * @implements \Serializable
	 */
	public function _UnserializeChangeMonitor($serialized) {
		$this->_initializeChangeMonitoring();
		
		$o = \unserialize($serialized);
		
		foreach ($this->_properties AS $property => &$data) {
			$data['value'] = $o->$property;
			unset($o->$property);
		}
		
		foreach (\get_object_vars($o) AS $property => $value) {
			$this->$property = $this->_UnserializeProperties($value);
		}
	}
	
	private function _UnserializeProperties($value) {
		if ($value instanceof \nexxes\WidgetIdentifier) {
			return $value->widget();
		}
		
		elseif (\is_array($value)) {
			$r = [];
			foreach ($value AS $k => $v) {
				$r[$k] = $this->_UnserializeProperties($v);
			}
			return $r;
		}
		
		else {
			return $value;
		}
	}
}
