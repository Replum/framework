<?php

namespace nexxes\widgets;

trait WidgetTrait {
	/**
	 * @var \nexxes\widgets\WidgetInterface
	 */
	private $_trait_Widget_parent = null;
	
	/**
	 * @implements \nexxes\widgets\WidgetInterface
	 */
	public function isRoot() {
		return (($this instanceof \nexxes\widgets\PageInterface) || is_null($this->_trait_Widget_parent));
	}
	
	/**
	 * @implements \nexxes\widgets\WidgetInterface
	 */
	public function getParent() {
		if (is_null($this->_trait_Widget_parent)) {
			throw new \InvalidArgumentException('No parent exists for this widget!');
		}
		
		return $this->_trait_Widget_parent;
	}
	
	/**
	 * @implements \nexxes\widgets\WidgetInterface
	 */
	public function setParent(\nexxes\widgets\WidgetInterface $newParent) {
		// Avoid recursion
		if ($this->_trait_Widget_parent === $newParent) {
			return $this;
		}
		
		$this->_trait_Widget_parent = $newParent;
		
		// Add to parent if it is a widget container (not for composites!)
		if (($newParent instanceof \nexxes\widgets\WidgetContainerInterface) && (!$newParent->hasChild($this))) {
			$newParent[] = $this;
		}
		
		return $this;
	}
	
	
	
	
	/**
	 * @var \nexxes\widgets\PageInterface
	 */
	private $_trait_Widget_page = null;
	
	/**
	 * @implements \nexxes\widgets\WidgetInterface
	 */
	public function getPage() {
		if (!is_null($this->_trait_Widget_page)) {
			return $this->_trait_Widget_page;
		}
		
		if ($this instanceof \nexxes\widgets\PageInterface) {
			return $this;
		}
		
		$this->_trait_Widget_page = $this->getParent()->getPage();
		return $this->_trait_Widget_page;
	}
	
	
	
	
	/**
	 * @var boolean
	 */
	private $_trait_widget_changed = false;
	
	/**
	 * @implements \nexxes\widgets\WidgetInterface
	 */
	public function isChanged() {
		return $this->_trait_widget_changed;
	}
	
	/**
	 * @implements \nexxes\widgets\WidgetInterface
	 */
	public function setChanged($changed = true) {
		$this->_trait_widget_changed = $changed;
		
		// If the current widget is not identifiable, it is not available in the list of widgets and can not be replaced in the web page.
		// Mark the parent widget as changed so it is re-rendered including this widget
		if ($changed && !($this instanceof \nexxes\widgets\IdentifiableInterface) && !$this->isRoot()) {
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
