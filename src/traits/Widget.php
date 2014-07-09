<?php

namespace nexxes\widgets\traits;

trait Widget {
	/**
	 * @var \nexxes\widgets\interfaces\Widget
	 */
	private $parent = null;
	
	/**
	 * @implements \nexxes\widgets\interfaces\Widget
	 */
	public function isRoot() {
		return ($this instanceof \nexxes\widgets\interfaces\Page);
	}
	
	/**
	 * @implements \nexxes\widgets\interfaces\Widget
	 */
	public function getParent() {
		return $this->parent;
	}
	
	/**
	 * @implements \nexxes\widgets\interfaces\Widget
	 */
	public function setParent(\nexxes\widgets\interfaces\Widget $newWidget) {
		$this->parent = $newWidget;
		return $this;
	}
}
