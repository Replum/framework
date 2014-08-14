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
	
	private $cacheNamespace = 'nexxes.pages';
	
	
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
			
		if (isset($_REQUEST['nexxes.page']) && ($_REQUEST['nexxes.page'] != "")) {
			$pagename = $_REQUEST['nexxes.page'];
		}	else {
			$pagename = 'Index';
		}
		
		// Handle vendor resources
		if (\substr($pagename, 0, 7) === 'vendor/') {
			return $this->handleVendorResource($pagename);
		}
		
		if (!\session_start()) {
			throw new \Exception('Failed to start new session');
		}
		
		if (isset($_REQUEST['nexxes_event'])) {
			return $this->handleEvent($_REQUEST['nexxes_event'], $_REQUEST['nexxes_pid'], $_REQUEST['nexxes_source']);
		}
		
		// Get the name and class of the current page
		$class = $this->pageNamespace . '\\' . $pagename;

		if (!\class_exists($class)) {
			throw new \InvalidArgumentException('Invalid page "' . $pagename . '"!');
		}
		
		// Restore a page
		/* @var $page interfaces\Page */
		$page = new $class();
		$page->id = $this->generatePageID();
		
		//\ini_set('session.use_cookies', false);
		//\ini_set('session.use_only_cookies', false);
		
		//\session_name(self::SESSION_VAR);
		
		//echo '<p>Session-Name: ' . \session_name() . '</p>';
		
		dep::registerObject(interfaces\Page::class, $page);
		dep::registerObject(WidgetRegistry::class, $page->getWidgetRegistry());
	}
	
	
	
	
	
	public function execute() {
		/* @var $page interfaces\Page */
		$page = dep::get(interfaces\Page::class);
		echo $page->__toString();
		
		\apc_store($this->cacheNamespace . '.' . $page->id, $page, 0);
	}
	
	
	
	/**
	 * Handle an ajax event
	 * 
	 * @param string $event
	 * @param string $page_id
	 * @param string $widget_id
	 * @throws \RuntimeException
	 */
	public function handleEvent($event, $page_id, $widget_id) {
		if ($event != "change") {
			throw new \InvalidArgumentException('Invalid event with name "' . $event . '"');
		}

		/* @var $page interfaces\Page */
		$page = \apc_fetch($this->cacheNamespace . '.' . $page_id);

		if (!($page instanceof interfaces\Page)) {
			throw new \RuntimeException('Can not restore page!');
		}

		$widget = $page->getWidgetRegistry()->getWidget($widget_id);
		$widget->setValue('Changed man!');

		$data = [];
		$data[] = [
			'nexxes_action' => 'replace',
			'nexxes_target' => $widget->getID(),
			'nexxes_data' => $widget->renderHTML(),
		];

		header('Content-Type: text/json');
		echo json_encode($data);
		exit;
	}
	
	
	
	
	protected function generatePageID() {
		$length = 8;
		
		do {
			$r = new \nexxes\common\RandomString($length);
			$length++;
		} while (\apc_exists($this->cacheNamespace . '.' . $r));
		
		return (string)$r;
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
		try {
			$this->createVendorResourceSymlink($resourceName, VENDOR_DIR, $_SERVER['DOCUMENT_ROOT']);
		} catch (\Exception $e) {
			header("HTTP/1.0 404 Not Found");
			echo '<pre>' . $e . '</pre>';
			exit;
		}
		
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
