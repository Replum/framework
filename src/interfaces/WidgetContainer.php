<?php

namespace nexxes\widgets\interfaces;

/**
 * Widgets that can contain other widgets are called containers.
 * 
 * This interface contains all methods required to manage child handling.
 */
interface WidgetContainer extends Widget {
	/**
	 * Add a child to the container
	 * 
	 * @param Widget $child
	 * @return WidgetContainer $this for chaining
	 */
	function addWidget(Widget $child);
	
	/**
	 * Remove a child from the container
	 * 
	 * @param Widget $child
	 * @return WidgetContainer $this for chaining
	 */
	function delWidget(Widget $child);
	
	/**
	 * Remove all children from the container
	 * @return WidgetContainer $this for chaining
	 */
	function clearWidgets();
	
	/**
	 * Get the list of current children
	 * 
	 * @return array<Widget>
	 */
	function widgets();
}
