<?php

namespace nexxes\widgets\traits;

/**
 * Default implementation for the Identifiable interface
 */
trait Identifiable {
	/**
	 * The page unique identifier for this widget
	 * 
	 * @var string
	 */
	private $id;
	
	/**
	 * @implements \nexxes\widgets\interfaces\Identifiable
	 */
	public function getID() {
		return $this->id;
	}
	
	/**
	 * @implements \nexxes\widgets\interfaces\Identifiable
	 */
	public function setID($newID) {
		$oldID = $this->id;
		$this->id = $newID;
		
		// Prevent recursion
		if (is_null($oldID) || ($oldID === $newID)) {
			return;
		}
		
		/* @var $registry \nexxes\widgets\WidgetRegistry */
		$registry = \nexxes\dependency\Gateway::get(\nexxes\widgets\WidgetRegistry::class);
		
		$registry->notifyIdChange($this);
		return $this;
	}
}
