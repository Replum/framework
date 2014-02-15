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
	 */
	function addWidget(iWidget $child);
	
	/**
	 * Get the list of current children
	 * 
	 * @return array<iWidget>
	 */
	function widgets();
}
