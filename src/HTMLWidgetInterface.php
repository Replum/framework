<?php

namespace nexxes\widgets;

interface HTMLWidgetInterface extends WidgetInterface {
	/**
	 * Add the class to the list of classes if not already contained.
	 * 
	 * @param string $class Class to add
	 * @return HTMLWidget $this for chaining
	 * @see http://www.w3.org/TR/html5/dom.html#classes
	 */
	function addClass($class);
	
	/**
	 * Remove the supplied class if it exists in the list of classes.
	 * If the class was not previously set, no error is raised.
	 * 
	 * @param string $class The class name or regex to remove by
	 * @param boolean $isRegex Indicates if $class specifies the literal class name or a (perl compatible) regex to match classes against
	 * @return HTMLWidget $this for chaining
	 * @see http://www.w3.org/TR/html5/dom.html#classes
	 */
	function delClass($class, $isRegex = false);
	
	/**
	 * Checks if the supplied class is set for this widget
	 * 
	 * @param string $class The class name or regex to check against
	 * @param boolean $isRegex Indicates if $removeClass specifies the literal class name or a (perl compatible) regex to match classes against
	 * @return boolean
	 * @see http://www.w3.org/TR/html5/dom.html#classes
	 */
	function hasClass($class, $isRegex = false);
	
	/**
	 * Get the list of classes set
	 * 
	 * @param string $regex The regex to filter awailable classes with.
	 * @return array<String>
	 * @see http://www.w3.org/TR/html5/dom.html#classes
	 */
	function getClasses($regex = null);
	
	/**
	 * Get the tabindex attribute.
	 * 
	 * @return int
	 * @see http://www.w3.org/TR/html5/editing.html#attr-tabindex
	 */
	function getTabIndex();
	
	/**
	 * Set the tabindex attribute.
	 * 
	 * @param int $newTabIndex
	 * @return HTMLWidget $this for chaining
	 * @see http://www.w3.org/TR/html5/editing.html#attr-tabindex
	 */
	function setTabIndex($newTabIndex);
	
	/**
	 * Get the title attribute of the element
	 * 
	 * @return string
	 * @see http://www.w3.org/TR/html5/dom.html#attr-title
	 */
	function getTitle();
	
	/**
	 * Set the title attribute of this element
	 * 
	 * @param string $newTitle
	 * @return HTMLWidget $this for chaining
	 * @see http://www.w3.org/TR/html5/dom.html#attr-title
	 */
	function setTitle($newTitle);
}
