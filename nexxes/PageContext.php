<?php

namespace nexxes;

/**
 * The pagecontext holds references to all relevant objects
 * like the current page, the dispatcher, whatever
 */
class PageContext {
	/**
	 * @var \Smarty
	 */
	public $smarty;
	
	/**
	 *
	 * @var \nexxes\property\Handler
	 */
	public $propertyHandler;
	
	public function __construct() {
		// Initialize smarty
		$this->smarty = new \Smarty();
		$this->smarty->setTemplateDir(VENDOR_DIR . '/../template');
		$this->smarty->setCompileDir(VENDOR_DIR . '/../tmp/smarty-compile');
		$this->smarty->setCacheDir(VENDOR_DIR . '/../tmp/smarty-cache');
		
		$this->propertyHandler = new property\Handler();
	}
}
