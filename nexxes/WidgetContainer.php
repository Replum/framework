<?php

namespace nexxes;

abstract class WidgetContainer extends Widget implements iWidgetContainer {
	/**
	 * The list of children added
	 * 
	 * @var array<iWidget>
	 */
	protected $_children = [];
	
	
	
	
	/**
	 * 
	 * @param \nexxes\iWidget $child
	 */
	public function add(iWidget $child) {
		$this->_children[] = $child;
		PageContext::$widgetRegistry->setParent($child, $this);
	}
	
	/**
	 * Get the list of current children
	 * 
	 * @return array<iWidget>
	 */
	public function children() {
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
