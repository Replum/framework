<?php

namespace nexxes\widgets\traits;

class WidgetHasEventsMock implements \nexxes\widgets\interfaces\WidgetHasEvents {
	use Identifiable;
	use WidgetHasEvents;
	
	public function addClass($newClass) {
	}

	public function delClass($delClass) {
	}

	public function getClasses() {
	}

	public function getParent() {
	}

	public function getTabIndex() {
	}

	public function getTitle() {
	}

	public function hasClass($class) {
	}

	public function isRoot() {
	}

	public function renderHTML() {
	}

	public function setParent(\nexxes\widgets\interfaces\Widget $newParent) {
	}

	public function setTabIndex($newTabIndex) {
	}

	public function setTitle($newTitle) {
	}
}
