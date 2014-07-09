<?php

namespace nexxes\widgets;

class WidgetContainer extends Widget implements interfaces\WidgetContainer {
	/**
	 * The list of children added
	 * 
	 * @var array<interfaces\Widget>
	 */
	protected $_children = [];
	
	
	
	
	/**
	 * @param interfaces\Widget $child
	 * @return WidgetContainer $this for chaining
	 */
	public function addWidget(interfaces\Widget $child) {
		$this->_children[] = $child;
		//PageContext::$widgetRegistry->setParent($child, $this);
		
		return $this;
	}
	
	/**
	 * @param interfaces\Widget $child
	 * @return WidgetContainer $this for chaining
	 */
	public function delWidget(interfaces\Widget $child) {
		$key = \array_search($child, $this->_children);
		if ($key !== false) {
			unset($this->_children[$key]);
		}
		
		return $this;
	}
	
	/**
	 * @return WidgetContainer $this for chaining
	 */
	public function clearWidgets() {
		$this->_children = [];
		
		return $this;
	}
	
	/**
	 * Get the list of current children
	 * 
	 * @return array<interfaces\Widget>
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
