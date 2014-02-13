<?php

namespace nexxes;

use \nexxes\PageContext;

class Executer {
	/**
	 * The namespace each page class must exist in
	 * @var string
	 */
	private $pageNamespace;
	
	
	
	
	public function __construct($pageNamespace = '\nexxes\pages') {
		$this->pageNamespace = $pageNamespace;
		
		// Initialize smarty
		PageContext::$smarty = new \Smarty();
		PageContext::$smarty->setTemplateDir(VENDOR_DIR . '/../template');
		PageContext::$smarty->setCompileDir(VENDOR_DIR . '/../tmp/smarty-compile');
		PageContext::$smarty->setCacheDir(VENDOR_DIR . '/../tmp/smarty-cache');
		
		// Parse request data
		PageContext::$request = new \nexxes\helper\RequestData();
		
		// Property annotation reader
		PageContext::$propertyHandler = new \nexxes\property\Handler();
		
		// Restore persisted page
		if (($pid = PageContext::$request->getPageID()) && (false !== ($serialized = \apc_fetch($pid)))) {
			echo "Restoring page<br>\n";
			
			PageContext::$widgetRegistry = \unserialize(\apc_fetch($pid . '-widgets'));
			PageContext::$page = \unserialize($serialized);
			
			echo "Page-ID: " . PageContext::$page->id . "<br>\n";
			echo "From Registry: " . PageContext::$widgetRegistry->pageID . "<br>\n";
		}
		
		else {
			// Get page from request or set default
			if (!($page = PageContext::$request->getPage())) {
				$page = 'Index';
			}
			
			// Get the name and class of the current page
			$class = $this->pageNamespace . '\\' . $page;

			if (!\class_exists($class)) {
				throw new \InvalidArgumentException('Invalid page "' . $page . '"!');
			}
			
			PageContext::$widgetRegistry = new \nexxes\helper\WidgetRegistry();
			PageContext::$page = new $class();
		}
	}
	
	
	public function execute() {
		PageContext::$page->render();
		
		PageContext::$page->persist();
		\apc_store(PageContext::$widgetRegistry->pageID . '-widgets', \serialize(PageContext::$widgetRegistry));
	}
}
