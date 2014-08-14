<?php

namespace nexxes\widgets;

class IdentifiableMock implements interfaces\Identifiable {
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
	
	// interface Widget
	
	public function isRoot() {
	}
	
	public function getParent() {
	}
	
	public function setParent(\nexxes\widgets\interfaces\Widget $newParent) {
	}
	
	public function getPage() {
	}
	
	public function isChanged() {
	}
	
	public function setChanged($changed = true) {
	}
	
	public function __toString() {
	}
	
	// interface HTMLWidget
	
	public function addClass($newClass) {
	}

	public function delClass($delClass) {
	}
	
	public function getClasses() {
	}

	public function hasClass($class) {
	}

	public function getTabIndex() {
	}

	public function setTabIndex($newTabIndex) {
	}

	public function getTitle() {
	}

	public function setTitle($newTitle) {
	}
}
