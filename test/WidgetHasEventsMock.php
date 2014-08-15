<?php

namespace nexxes\widgets;

class WidgetHasEventsMock implements WidgetHasEventsInterface {
	use IdentifiableTrait, WidgetHasEventsTrait;
	
	// interface Widget
	
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