<?php

namespace nexxes\widgets\interfaces;

interface HTMLWidget extends Widget {
	/**
	 * Add the class to the list of classes if not already contained.
	 * 
	 * @param string $newClass Class to add
	 * @return HTMLWidget $this for chaining
	 * @see http://www.w3.org/TR/html5/dom.html#classes
	 */
	function addClass($newClass);
	
	/**
	 * Remove the supplied class if it exists in the list of classes.
	 * If the class was not previously set, no error is raised.
	 * 
	 * @param string $delClass Class to remove
	 * @return HTMLWidget $this for chaining
	 * @see http://www.w3.org/TR/html5/dom.html#classes
	 */
	function delClass($delClass);
	
	/**
	 * Checks if the supplied class is set for this widget
	 * 
	 * @param string $class
	 * @return boolean
	 * @see http://www.w3.org/TR/html5/dom.html#classes
	 */
	function hasClass($class);
	
	/**
	 * Get the list of classes set
	 * 
	 * @return array<String>
	 * @see http://www.w3.org/TR/html5/dom.html#classes
	 */
	function getClasses();
	
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
