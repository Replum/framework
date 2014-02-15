<?php

namespace nexxes;

/**
 * A page represents the main entity to visualize
 */
interface iPage extends iWidgetContainer {
	/**
	 * (Re)-Initialize the widget with page-specific non-persistable data like database connections
	 * 
	 * @param \nexxes\iWidget $widget
	 */
	function initWidget(\nexxes\iWidget $widget);
}
