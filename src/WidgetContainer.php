<?php

namespace nexxes;

class WidgetContainer extends Widget implements iWidgetContainer {
	/**
	 * The list of children added
	 * 
	 * @var array<iWidget>
	 */
	protected $_children = [];
	
	
	
	
	/**
	 * @param \nexxes\iWidget $child
	 * @return \nexxes\WidgetContainer
	 */
	public function addWidget(iWidget $child) {
		$this->_children[] = $child;
		PageContext::$widgetRegistry->setParent($child, $this);
		
		return $this;
	}
	
	/**
	 * @param \nexxes\iWidget $child
	 * @return \nexxes\WidgetContainer
	 */
	public function delWidget(iWidget $child) {
		$key = \array_search($child, $this->_children);
		if ($key !== false) {
			unset($this->_children[$key]);
		}
		
		return $this;
	}
	
	/**
	 * @return \nexxes\WidgetContainer
	 */
	public function clearWidgets() {
		$this->_children = [];
		
		return $this;
	}
	
	/**
	 * Get the list of current children
	 * 
	 * @return array<iWidget>
	 */
	public function widgets() {
		return $this->_children;
	}
	
	/**
	 * Render the HTML code for the children of this container
	 * 
	 * @return string
	 */
	public function renderChildrenHTML() {
		$r = '';
		
		foreach ($this->_children AS $child) {
			$r .= $child->renderHTML();
		}
		
		return $r;
	}
	
	protected function smarty() {
		$smarty = parent::smarty();
		$smarty->assign('children', $this->_children);
		return $smarty;
	}
}
