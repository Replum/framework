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
		//PageContext::$smarty->loadFilter('output', 'trimwhitespace');
		
		// Parse request data
		PageContext::$request = new \nexxes\helper\RequestData();
		PageContext::$smarty->assign('request', PageContext::$request);
		
		// Property annotation reader
		PageContext::$propertyHandler = new \nexxes\property\Handler();
		
		// Restore persisted page
		if ($pid = PageContext::$request->getPageID()) {
			helper\WidgetRegistry::restore($pid);
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
			PageContext::$widgetRegistry->page = new $class();
			PageContext::$page = PageContext::$widgetRegistry->page;
		}
	}
	
	
	public function execute() {
		if ($widgetID = PageContext::$request->getWidgetID()) {
			$widget = PageContext::$widgetRegistry->getWidget($widgetID);
			PageContext::$page->initWidget($widget);
			echo $widget->renderHTML();
		}
		
		else {
			PageContext::$page->render();
		}
		
		PageContext::$widgetRegistry->persist();
	}
}
