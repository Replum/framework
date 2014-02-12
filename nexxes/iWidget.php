<?php

namespace nexxes;

/**
 * Base interface for all widgets
 */
interface iWidget {
	/**
	 * The widget has changed properties
	 * @return bool
	 */
	public function hasChanged();
	
	/**
	 * Returns a list of property->newvalue pairs
	 * @return array
	 */
	public function getChanges();
}
