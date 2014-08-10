<?php

namespace nexxes\widgets\traits;

class WidgetHasEventsMock implements \nexxes\widgets\interfaces\WidgetHasEvents {
	use Identifiable;
	use WidgetHasEvents;
	
	// interface Widget
	
	public function isRoot() {
	}
	
	public function renderHTML() {
	}
	
	public function getParent() {
	}
	
	public function setParent(\nexxes\widgets\interfaces\Widget $newParent) {
	}
	
	public function isChanged() {
	}
	
	public function setChanged($changed = true) {
	}
	
	// interface HTMLWidget
	
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
}
