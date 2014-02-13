<?php

namespace nexxes;

use \nexxes\PageContext;

class Executer {
	/**
	 * The namespace each page class must exist in
	 * @var string
	 */
	private $pageNamespace;
	
	/**
	 * @var \nexxes\iPage
	 */
	private $page;
	
	public function __construct($pageNamespace = '\nexxes\pages') {
		$this->pageNamespace = $pageNamespace;
		
		// Initialize smarty
		PageContext::$smarty = new \Smarty();
		PageContext::$smarty->setTemplateDir(VENDOR_DIR . '/../template');
		PageContext::$smarty->setCompileDir(VENDOR_DIR . '/../tmp/smarty-compile');
		PageContext::$smarty->setCacheDir(VENDOR_DIR . '/../tmp/smarty-cache');
		
		// Property annotation reader
		PageContext::$propertyHandler = new \nexxes\property\Handler();
		
		// Get the name and class of the current page
		$page = (isset($_REQUEST['page']) ? $_REQUEST['page'] : 'Index');
		$class = $this->pageNamespace . '\\' . $page;

		if (!\class_exists($class)) {
			throw new \InvalidArgumentException('Invalid page "' . $page . '"!');
		}
		
		// Restore persisted page
		if (isset($_REQUEST['pid']) && (false !== ($serialized = \apc_fetch($_REQUEST['pid'])))) {
			$this->page = \unserialize($serialized);
			if (!($this->page instanceof $class)) {
				throw new \InvalidArgumentException('Invalid page access!');
			}
		}
		
		else {
			PageContext::$widgetRegistry = new \nexxes\WidgetRegistry();
			$this->page = new $class();
		}
	}
	
	public function execute() {
		$this->page->render();
		$this->page->persist();
	}
}
