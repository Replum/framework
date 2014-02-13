<?php

namespace nexxes\property;

use \nexxes\PageContext;

/**
 * This trait updates property values from the request variables according the property annotation config.
 */
trait UpdateValuesTrait {
	/**
	 * 
	 */
	public function updateValues() {
		// Widget ID
		$id = $this->id;
		
		// Property settings for this widget
		$properties = PageContext::$propertyHandler->getProperties($this);
		
		foreach ($properties AS $property) {
			if (!$property->fill) {
				continue;
			}
			
			$request_var = $id . '|' . $property->name;
			if (!isset($_REQUEST[$request_var])) {
				continue;
			}
			
			$raw = $_REQUEST[$request_var];
			
			if ($property->scalar) {
				$data = call_user_func([$this, 'sanitize' . \ucfirst($property->type) . 'Value'], $property, $raw);
			}
			
			else {
				$class = $property->type;
				$data = new $class($raw);
			}
			
			// FIXME: handle arrays
			$this->{$property->name} = $data;
		}
	}
	
	/**
	 * Sanitize boolean data
	 * 
	 * @param Config $property
	 * @param string $raw The unchecked value
	 * @return bool
	 */
	private function sanitizeBoolValue($property, $raw) {
		$data = \strtolower($raw);
		
		if (\in_array($data, ['true', 'yes', 'on', '1', 'ja', 'y'])) {
			return true;
		}
		
		elseif (\in_array($data, ['false', 'no', 'off', '0', 'nein', 'n'])) {
			return false;
		}
		
		else {
			throw new \InvalidArgumentException('Invalid value "' . $raw . '" for boolean property "' . $property->name . '" of class "' . \get_class($this) . '"');
		}
	}
	
	/**
	 * Sanitize integer data
	 * 
	 * @param Config $property
	 * @param string $raw The unchecked value
	 * @return int
	 */
	private function sanitizeIntValue($property, $raw) {
		if (!\is_numeric($raw)) {
			throw new \InvalidArgumentException('Invalid value "' . $raw . '" for integer property "' . $property->name . '" of class "' . \get_class($this) . '"');
		}
		
		$data = \intval($raw);
		
		if (isset($property->min) && ($data < $property->min)) {
			throw new \OutOfRangeException('Minimum value is "' . $property->min . '", "' . $data . '" given for property "' . $property->name . '" of class "' . \get_class($this) . '"');
		}
		
		if (isset($property->max) && ($property->max < $data)) {
			throw new \OutOfRangeException('Maximum value is "' . $property->max . '", "' . $data . '" given for property "' . $property->name . '" of class "' . \get_class($this) . '"');
		}
		
		return $data;
	}
	
		/**
	 * Sanitize float data
	 * 
	 * @param Config $property
	 * @param string $raw The unchecked value
	 * @return float
	 */
	private function sanitizeFloatValue($property, $raw) {
		if (!\is_numeric($raw)) {
			throw new \InvalidArgumentException('Invalid value "' . $raw . '" for float property "' . $property->name . '" of class "' . \get_class($this) . '"');
		}
		
		$data = \floatval($raw);
		
		if (isset($property->min) && ($data < $property->min)) {
			throw new \OutOfRangeException('Minimum value is "' . $property->min . '", "' . $data . '" given for property "' . $property->name . '" of class "' . \get_class($this) . '"');
		}
		
		if (isset($property->max) && ($property->max < $data)) {
			throw new \OutOfRangeException('Maximum value is "' . $property->max . '", "' . $data . '" given for property "' . $property->name . '" of class "' . \get_class($this) . '"');
		}
		
		return $data;
	}
	
	/**
	 * Sanitize string data
	 * 
	 * @param Config $property
	 * @param string $raw The unchecked value
	 * @return string
	 */
	private function sanitizeStringValue($property, $raw) {
		$data = \strval($raw);
		
		if (isset($property->match) && !preg_match($property->match, $data)) {
			throw new \InvalidArgumentException('Invalid value "' . $raw . '" for string property "' . $property->name . '" of class "' . \get_class($this) . '" does not match regular expression "' . $property->match . '"');
		}
		
		return $data;
	}
}
