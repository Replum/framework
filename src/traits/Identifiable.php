<?php

namespace nexxes\widgets\traits;

use \nexxes\dependency\Gateway as dep;
use \nexxes\widgets\WidgetRegistry;

/**
 * Default implementation for the Identifiable interface
 */
trait Identifiable {
	/**
	 * The page unique identifier for this widget
	 * 
	 * @var string
	 */
	private $_trait_Identifiable_id;
	
	/**
	 * @implements \nexxes\widgets\interfaces\Identifiable
	 */
	public function getID() {
		return $this->_trait_Identifiable_id;
	}
	
	/**
	 * @implements \nexxes\widgets\interfaces\Identifiable
	 */
	public function setID($newID) {
		$oldID = $this->_trait_Identifiable_id;
		$this->_trait_Identifiable_id = $newID;
		
		// Prevent recursion
		if (is_null($oldID) || ($oldID === $newID)) {
			return;
		}
		
		/* @var $registry WidgetRegistry */
		$registry = dep::get(WidgetRegistry::class);
		
		$registry->notifyIdChange($this);
		return $this;
	}
	
	/**
	 * 
	 * @return string
	 * @see http://www.w3.org/TR/html5/dom.html#the-id-attribute
	 */
	protected function getIDHTML() {
		return (\is_null($this->_trait_Identifiable_id) ? '' : ' id="' . $this->escape($this->_trait_Identifiable_id) . '"');
	}
}
