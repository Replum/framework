<?php

namespace nexxes\widgets;

class IdentifiableMock implements IdentifiableInterface {
	protected $id;
	
	public function __construct($id = null) {
		$this->id = $id;
	}
	
	public function getID() {
		return $this->id;
	}

	public function setID($newID) {
		$this->id = $newID;
	}
	
	// WidgetInterface
	
	public function isRoot() {
	}
	
	public function getParent() {
	}
	
	public function setParent(WidgetInterface $newParent) {
	}
	
	public function getPage() {
	}
	
	public function isChanged() {
	}
	
	public function setChanged($changed = true) {
	}
	
	public function __toString() {
	}
}
