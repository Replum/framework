<?php

namespace nexxes\widgets;

/**
 * @author Dennis Birkholz <dennis.birkholz@nexxes.net>
 */
class WidgetContainerTraitMock implements WidgetContainerInterface {
	use WidgetContainerTrait;
	
	public function __toString() {
	}

	public function addClass($class) {
	}

	public function delClass($class, $isRegex = false) {
	}

	public function getClasses($regex = null) {
	}

	public function getID() {
	}

	public function getPage() {
	}

	public function getParent() {
	}

	public function getTabIndex() {
	}

	public function getTitle() {
	}

	public function hasClass($class, $isRegex = false) {
	}

	public function isChanged() {
	}

	public function isRoot() {
	}

	public function setChanged($changed = true) {
	}

	public function setID($newID) {
	}

	public function setParent(WidgetInterface $newParent) {
	}

	public function setTabIndex($newTabIndex) {
	}

	public function setTitle($newTitle) {
	}
}
