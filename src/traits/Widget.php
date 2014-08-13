<?php

namespace nexxes\widgets\traits;

trait Widget {
	/**
	 * @var \nexxes\widgets\interfaces\Widget
	 */
	private $_trait_widget_parent = null;
	
	/**
	 * @implements \nexxes\widgets\interfaces\Widget
	 */
	public function isRoot() {
		return (($this instanceof \nexxes\widgets\interfaces\Page) || is_null($this->_trait_widget_parent));
	}
	
	/**
	 * @implements \nexxes\widgets\interfaces\Widget
	 */
	public function getParent() {
		return $this->_trait_widget_parent;
	}
	
	/**
	 * @implements \nexxes\widgets\interfaces\Widget
	 */
	public function setParent(\nexxes\widgets\interfaces\Widget $newWidget) {
		$this->_trait_widget_parent = $newWidget;
		return $this;
	}
	
	/**
	 * @implements \nexxes\widgets\interfaces\Widget
	 */
	public function getPage() {
		if ($this instanceof \nexxes\widgets\interfaces\Page) {
			return $this;
		}
		
		elseif ($this->_trait_widget_parent !== null) {
			return $this->_trait_widget_parent->getParent()->getPage();
		}
		
		else {
			return null;
		}
	}
	
	
	/**
	 * @var boolean
	 */
	private $_trait_widget_changed = false;
	
	/**
	 * @implements \nexxes\widgets\interfaces\Widget
	 */
	public function isChanged() {
		return $this->_trait_widget_changed;
	}
	
	/**
	 * @implements \nexxes\widgets\interfaces\Widget
	 */
	public function setChanged($changed = true) {
		$this->_trait_widget_changed = $changed;
		
		// If the current widget is not identifiable, it is not available in the list of widgets and can not be replaced in the web page.
		// Mark the parent widget as changed so it is re-rendered including this widget
		if ($changed && !($this instanceof \nexxes\widgets\interfaces\Identifiable) && !$this->isRoot()) {
			$this->getParent()->setChanged($changed);
		}
		
		return $this;
	}
	
	/**
	 * On restoring the widget on a successive call, mark it as unchanged
	 */
	public function __wakeup() {
		$this->_trait_widget_changed = false;
	}
}
