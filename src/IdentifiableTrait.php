<?php

namespace nexxes\widgets;

use \nexxes\widgets\WidgetRegistry;

/**
 * Default implementation for the Identifiable interface
 */
trait IdentifiableTrait {
	/**
	 * The page unique identifier for this widget
	 * 
	 * @var string
	 */
	private $IdentifiableTraitId;
	
	/**
	 * @implements \nexxes\widgets\IdentifiableInterface
	 */
	public function getID() {
		return $this->IdentifiableTraitId;
	}
	
	/**
	 * @implements \nexxes\widgets\IdentifiableInterface
	 */
	public function setID($newID) {
		$oldID = $this->IdentifiableTraitId;
		$this->IdentifiableTraitId = $newID;
		
		// Prevent recursion
		if (is_null($oldID) || ($oldID === $newID)) {
			return;
		}
		
		/* @var $registry WidgetRegistry */
		$registry = $this->getPage()->getWidgetRegistry();
		
		$registry->notifyIdChange($this);
		return $this;
	}
	
	/**
	 * 
	 * @return string
	 * @see http://www.w3.org/TR/html5/dom.html#the-id-attribute
	 */
	protected function getIDHTML() {
		return (\is_null($this->IdentifiableTraitId) ? '' : ' id="' . $this->escape($this->IdentifiableTraitId) . '"');
	}
}
