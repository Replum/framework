<?php

namespace nexxes\widgets\interfaces;

/**
 * A page represents the main entity to visualize
 */
interface Page extends WidgetContainer {
	/**
	 * Get the widget registry associated with this page
	 * @return \nexxes\widgets\WidgetRegistry
	 */
	function getWidgetRegistry();
}
