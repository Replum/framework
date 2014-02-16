<?php

namespace nexxes;

/**
 * The context trait handles getting/setting of the page context object
 */
trait ContextTrait {
	/**
	 * @var \nexxes\PageContext
	 */
	private $_context;
	
	/**
	 * @return \nexxes\PageContext
	 */
	public function getContext() {
		return $this->_context;
	}
	
	/**
	 * Set the current page context
	 * 
	 * @param \nexxes\PageContext $context
	 */
	public function setContext(\nexxes\PageContext $context) {
		$this->_context = $context;
	}
}
