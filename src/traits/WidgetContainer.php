<?php

namespace nexxes\widgets\traits;

trait WidgetContainer {
	/**
	 * @var array<\nexxes\widgets\interfaces\Widget>
	 */
	private $_trait_WidgetContainer_children = [];
	
	/**
	 * @implements \nexxes\widgets\interfaces\WidgetContainer
	 */
	public function addWidget(\nexxes\widgets\interfaces\Widget $child) {
		if (!\in_array($child, $this->_trait_WidgetContainer_children)) {
			$this->_trait_WidgetContainer_children[] = $child;
			$child->setParent($this);
			
			$this->setChanged(true);
		}
		
		return $this;
	}

	/**
	 * @implements \nexxes\widgets\interfaces\WidgetContainer
	 */
	public function delWidget(\nexxes\widgets\interfaces\Widget $child) {
		if (\in_array($child, $this->_trait_WidgetContainer_children)) {
			// FIXME: un-register cleared widget
			$key = \array_search($child, $this->_trait_WidgetContainer_children, true);
			unset($this->_trait_WidgetContainer_children[$key]);
			
			$this->setChanged(true);
		}
		
		return $this;
	}

	/**
	 * @implements \nexxes\widgets\interfaces\WidgetContainer
	 */
	public function clearWidgets() {
		// FIXME: un-register cleared widgets
		$this->_trait_WidgetContainer_children = [];
		
		$this->setChanged(true);
		
		return $this;
	}
	
	/**
	 * @implements \nexxes\widgets\interfaces\WidgetContainer
	 */
	public function widgets() {
		return $this->_trait_WidgetContainer_children;
	}
}
