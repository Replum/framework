<?php

namespace nexxes\widgets;

class IdentifiableMock implements interfaces\Identifiable {
	protected $id;

	public function getID() {
		return $this->id;
	}

	public function setID($newID) {
		$this->id = $newID;
	}

	public function renderHTML() {
	}

	public function addClass($newClass) {
	}

	public function delClass($delClass) {
	}

	public function getClasses() {
	}

	public function getTabIndex() {
	}

	public function getTitle() {
	}

	public function hasClass($class) {
	}

	public function setTabIndex($newTabIndex) {
	}

	public function setTitle($newTitle) {
	}

	public function getParent() {
	}

	public function isRoot() {
	}

	public function setParent(interfaces\Widget $newParent) {
	}

	public function isChanged() {
	}

	public function setChanged($changed = true) {
	}

}
