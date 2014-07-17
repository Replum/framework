<?php

namespace nexxes\widgets;

use \nexxes\dependency\Gateway as dep;
use \nexxes\common\RelativePath;

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
		
		//\ini_set('session.use_cookies', false);
		//\ini_set('session.use_only_cookies', false);
		
		//\session_name(self::SESSION_VAR);
		
		//echo '<p>Session-Name: ' . \session_name() . '</p>';
		
		if (!\session_start()) {
			echo "<p>Failed to start session</p>";
		} else {
			echo "<p>Session started!</p>";
		}
		
		/* @var $page interfaces\Page */
		$page = new $class();
		dep::registerObject(interfaces\Page::class, $page);
		dep::registerObject(WidgetRegistry::class, $page->getWidgetRegistry());
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
	
	/**
	 * Handle a resource that is accessed via the vendor/ directory in the web root.
	 * Vendor resources must exist in the public/ directory of the composer installed
	 * dependency, which is $PROJECT_ROOT/vendor/$VENDOR/$PROJECT/public/.
	 * 
	 * If a dependency has no public/ folder, it can not export static file into the web root.
	 * 
	 * The resources are symlinked from the public/ directory into the vendor/-directory under the document root.
	 * 
	 * A test.js-file of the nexxes/jstest dependency would result in a symlink from
	 * $PROJECT_ROOT/vendor/nexxes/jstest/public/test.js to $DOCUMENT_ROOT/vendor/nexxes/jstest/test.js
	 * 
	 * @param type $resourceName
	 * @throws \InvalidArgumentException
	 */
	public function handleVendorResource($resourceName) {
		$this->createVendorResourceSymlink($resourceName, VENDOR_DIR, $_SERVER['DOCUMENT_ROOT']);
		header('Location: ' . $_SERVER["REQUEST_URI"]);
		exit;
	}
	
	/**
	 * @param string $resource The resource name = path below the document root
	 * @param string $vendor_dir Vendor dir used by composer to install dependencies into
	 * @param string $document_root Directory that is accessible thru the web server
	 * @throws \InvalidArgumentException
	 * @see self::handleVendorResource
	 */
	protected function createVendorResourceSymlink($resourceName, $vendor_dir, $document_root) {
		@list($prefix, $vendor, $package, $path) = \explode('/', $resourceName, 4);
		
		if ($prefix != 'vendor') {
			throw new \InvalidArgumentException('Invalid resource selection!', 1);
		}
		
		if (($vendor == '.') || ($vendor == '..')) {
			throw new \InvalidArgumentException('Invalid resource selection!', 2);
		}
		
		if (!\is_dir($vendor_dir . '/' . $vendor)) {
			throw new \InvalidArgumentException('Invalid resource selection!', 3);
		}
		
		if (($package == '.') || ($package == '..')) {
			throw new \InvalidArgumentException('Invalid resource selection!', 4);
		}
		
		if (!\is_dir($vendor_dir . '/' . $vendor . '/' . $package)) {
			throw new \InvalidArgumentException('Invalid resource selection!', 5);
		}
		
		if (!\is_dir($vendor_dir . '/' . $vendor . '/' . $package . '/public')) {
			throw new \InvalidArgumentException('Invalid resource selection!', 6);
		}
		
		if (\strpos($path, '..') !== false) {
			throw new \InvalidArgumentException('Invalid resource selection!', 7);
		}
		
		if (!\file_exists($vendor_dir . '/' . $vendor . '/' . $package . '/public/' . $path)) {
			throw new \InvalidArgumentException('Invalid resource selection!', 8);
		}
		
		$linkname = $document_root . '/vendor/' . $vendor . '/' . $package . '/' . $path;
		$fulltarget = $vendor_dir . '/' . $vendor . '/' . $package . '/public/' . $path;
		
		\mkdir(\dirname($linkname), 0755, true);
		\symlink((string)new RelativePath($linkname, $fulltarget), $linkname);
	}
}
