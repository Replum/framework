<?php

namespace nexxes\widgets;

/**
 * A WidgetContainer holds an ordered collection (list) of widgets.
 * All children are rendered in the stored order.
 * The WidgetContainer may arrange the children in a specific visual order (e.g. rows or columns).
 * The difference between a container and a composite is that the container can hold any children whereas the composite is always assembled of the same set of child widgets.
 */
interface WidgetContainerInterface extends WidgetInterface {
	/**
	 * Get the list of children of this container.
	 * @return DependentWidgetList
	 */
	public function children();
}
