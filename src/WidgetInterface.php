<?php

namespace nexxes\widgets;

/**
 * Base interface for all widgets
 */
interface WidgetInterface {
	/**
	 * Check if the selected widget is the topmost widget aka the page
	 * 
	 * @return boolean
	 */
	function isRoot();
	
	/**
	 * Get the parent of this widget, used to navigate to the top of the widget tree.
	 * 
	 * @return \nexxes\widgets\WidgetInterface
	 */
	function getParent();
	
	/**
	 * Set the current parent widget for the current widget.
	 * Should not called directly to avoid creating corrupt widget hierarchies.
	 * Instead this method should be called from a container when a widget is added to that container.
	 * 
	 * @param \nexxes\widgets\WidgetInterface
	 * @return \nexxes\widgets\WidgetInterface $this for chaining
	 */
	function setParent(WidgetInterface $newParent);
	
	/**
	 * Get the page this widget belongs to
	 * 
	 * @return \nexxes\widgets\PageInterface
	 */
	function getPage();
	
	/**
	 * Check if the widget is marked as changed
	 * 
	 * @return boolean
	 */
	function isChanged();
	
	/**
	 * Set/unset the changed status of the widget
	 * 
	 * @param boolean
	 * @return \nexxes\widgets\WidgetInterface $this for chaining
	 */
	function setChanged($changed = true);
	
	/**
	 * Render the HTML representation of the widget and return it as a string
	 * 
	 * @return string The HTML code of the widget
	 */
	function __toString();
}
