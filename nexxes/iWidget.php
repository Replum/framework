<?php

namespace nexxes;

/**
 * Base interface for all widgets
 */
interface iWidget {
	/**
	 * The widget has changed properties
	 * @return bool
	 */
	function hasChanged();
	
	/**
	 * Returns a list of property->newvalue pairs
	 * @return array
	 */
	function getChanges();
	
	/**
	 * Set a property of the class
	 * 
	 * @param string $name Name of the property to change
	 * @param mixed $value The value to set
	 * @return \nexxes\iWidget The widget for chaining
	 */
	function set($property, $value);
	
	/**
	 * Add the supplied value to the array property named $property
	 * 
	 * @param string $property Name of the property to modify
	 * @param mixed $value The value to add to the property
	 * @return \nexxes\iWidget The widget for chaining
	 */
	function add($property, $value);
	
	/**
	 * Remove the supplied value from the array property named $property
	 * 
	 * @param string $property Name of the property to modify
	 * @param mixed $value The value to remove from the property
	 * @return \nexxes\iWidget The widget for chaining
	 */
	function del($property, $value);
	
	/**
	 * Render the HTML representation of the widget and return it as a string
	 * 
	 * @return string The HTML code of the widget
	 */
	function renderHTML();
}
