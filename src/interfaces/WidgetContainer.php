<?php

namespace nexxes\widgets\interfaces;

/**
 * A WidgetContainer holds an ordered collection (list) of widgets.
 * All children are rendered in the stored order.
 * The WidgetContainer may arrange the children in a specific visual order (e.g. rows or columns).
 * The difference between a container and a composite is that the container can hold any children whereas the composite is always assembled of the same set of child widgets.
 */
interface WidgetContainer extends Widget, \ArrayAccess, \Countable, \IteratorAggregate {
	/**
	 * Check whether the supplied widget is a child of this container
	 * 
	 * @param \nexxes\widgets\interfaces\Widget $widget
	 * @return boolean
	 */
	function hasChild(\nexxes\widgets\interfaces\Widget $widget);
}
