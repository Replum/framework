<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace nexxes\widgets;

/**
 * Description of PageTraitMock
 *
 * @author Dennis Birkholz <dennis.birkholz@nexxes.net>
 */
class PageTraitMock implements PageInterface {
	use PageTrait;

	public function getPage() {
		return $this;
	}
	
	public function __toString() {
	}

	public function addClass($class) {
	}

	public function count() {
	}

	public function delClass($class, $isRegex = false) {
	}

	public function escape($unquoted) {
	}

	public function getClasses($regex = null) {
	}

	public function getID() {
	}

	public function getIterator() {
	}

	public function getParent() {
	}

	public function getTabIndex() {
	}

	public function hasChild(WidgetInterface $widget) {
	}

	public function hasClass($class, $isRegex = false) {
	}

	public function isChanged() {
	}

	public function isRoot() {
	}

	public function offsetExists($offset) {
	}

	public function offsetGet($offset) {
	}

	public function offsetSet($offset, $value) {
	}

	public function offsetUnset($offset) {
	}

	public function setChanged($changed = true) {
	}

	public function setID($newID) {
	}

	public function setParent(WidgetInterface $newParent) {
	}

	public function setTabIndex($newTabIndex) {
	}
}
