<?php

namespace nexxes;

/**
 * Widgets that can contain other widgets are called containers.
 * 
 * This interface contains all methods required to manage child handling.
 */
interface iWidgetContainer extends iWidget {
	/**
	 * Add a child to the container
	 * 
	 * @param iWidget $child
	 * @return iWidgetContainer $this for chaining
	 */
	function addWidget(iWidget $child);
	
	/**
	 * Remove a child from the container
	 * 
	 * @param iWidget $child
	 * @return iWidgetContainer $this for chaining
	 */
	function delWidget(iWidget $child);
	
	/**
	 * Remove all children from the container
	 * @return iWidgetContainer $this for chaining
	 */
	function clearWidgets();
	
	/**
	 * Get the list of current children
	 * 
	 * @return array<iWidget>
	 */
	function widgets();
}
