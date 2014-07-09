<?php

namespace nexxes\widgets;

use \nexxes\dependency\Gateway as dep;

/**
 * The Executer creates or restores the current page and the associated widget registry
 */
class Executer {
	/**
	 * The namespace each page class must exist in
	 * @var string
	 */
	private $pageNamespace;
	
	const SESSION_VAR = 's';
	
	
	
	public function __construct($pageNamespace = '\nexxes\pages') {
		$this->pageNamespace = $pageNamespace;
		
		// Restore persisted page
//		if ($pid = PageContext::$request->getPageID()) {
//			helper\WidgetRegistry::restore($pid);
//		}
		
//		else {
			// Get page from request or set default
			//if (!($page = PageContext::$request->getPage())) {
				
			//}
			
		if (isset($_REQUEST['page']) && ($_REQUEST['page'] != "")) {
			$page = $_REQUEST['page'];
		} else {
			$page = 'Index';
		}
		
			// Get the name and class of the current page
			$class = $this->pageNamespace . '\\' . $page;

			if (!\class_exists($class)) {
				throw new \InvalidArgumentException('Invalid page "' . $page . '"!');
			}
			
					\ini_set('session.use_cookies', false);
		\ini_set('session.use_only_cookies', false);
		
		//\session_name(self::SESSION_VAR);
		
		//echo '<p>Session-Name: ' . \session_name() . '</p>';
		
		if (!\session_start()) {
			echo "<p>Failed to start session</p>";
		} else {
			echo "<p>Session started!</p>";
		}
		
		if (!isset($_SESSION['counter'])) {
			$_SESSION['counter'] = 0;
		}
		
		echo "<p>Counter: " . ++$_SESSION['counter'] . "</p>";
		
			/* @var $page interfaces\Page */
			$page = new $class();
			dep::registerObject(interfaces\Page::class, $page);
			dep::registerObject(WidgetRegistry::class, $page->getWidgetRegistry());
//		}
	}
	
	
	public function execute() {
		dep::get(interfaces\Page::class)->render();
		
		/*
		if ($widgetID = PageContext::$request->getWidgetID()) {
			$widget = PageContext::$widgetRegistry->getWidget($widgetID);
			echo $widget->renderHTML();
		}
		
		else {
			PageContext::$page->render();
		}
		
		PageContext::$widgetRegistry->persist();
	 */
	}
}
