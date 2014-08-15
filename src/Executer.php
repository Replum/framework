<?php

namespace nexxes\widgets;

use \nexxes\dependency\Gateway as dep;
use \nexxes\common\RelativePath;

/**
 * The Executer creates or restores the current page and the associated widget registry
 */
class Executer {
	/**
	 * @var \Symfony\Component\HttpFoundation\Request
	 */
	private $request = null;
	
	/**
	 * Get the request object of the current request
	 * 
	 * @return \Symfony\Component\HttpFoundation\Request
	 */
	public function getRequest() {
		return $this->request;
	}
	
	
	
	
	/**
	 * @var \Symfony\Component\HttpFoundation\Session\Session
	 */
	private $session = null;
	
	/**
	 * Get the currently active session
	 * 
	 * @return \Symfony\Component\HttpFoundation\Session\Session
	 */
	public function getSession() {
		return $this->session;
	}
	
	
	
	
	/**
	 * The namespace each page class must exist in
	 * @var string
	 */
	private $pageNamespace;
	
	public function getPageNamespace() {
		return $this->pageNamespace;
	}
	
	private $cacheNamespace = 'nexxes.pages';
	
	public function getCacheNamespace() {
		return $this->cacheNamespace;
	}
	
	private $actionhandler = [];
	
	public function registerAction($actionName, $handlerClass) {
		$this->actionhandler[$actionName] = $handlerClass;
		return $this;
	}
	
	
	
	
	
	
	
	
	
	
	
	public function __construct($pageNamespace = '\nexxes\pages') {
		$this->pageNamespace = $pageNamespace;
		
		// Handle request and session
		$this->request = \Symfony\Component\HttpFoundation\Request::createFromGlobals();
		
		if ($this->request->hasPreviousSession() || $this->request->hasSession()) {
			$this->session = $this->request->getSession();
		} else {
			$this->session = new \Symfony\Component\HttpFoundation\Session\Session();
			$this->request->setSession($this->session);
		}
		
		if (!$this->session->isStarted()) {
			$this->session->start();
		}
		
		// Security measure: regenerate session id to avoid session fixation
		//$this->session->migrate();
		
		$this->registerAction('page', \nexxes\widgets\actionhandler\PageHandler::class);
		$this->registerAction('json', \nexxes\widgets\actionhandler\JsonHandler::class);
		$this->registerAction('vendor', \nexxes\widgets\actionhandler\VendorHandler::class);
		

		
		// Restore persisted page
//		if ($pid = PageContext::$request->getPageID()) {
//			helper\WidgetRegistry::restore($pid);
//		}
		
//		else {
			// Get page from request or set default
			//if (!($page = PageContext::$request->getPage())) {
				
			//}
		/*
			
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
		/ * @var $page interfaces\Page * /
		$page = new $class();
		$page->id = $this->generatePageID();
		
		//\ini_set('session.use_cookies', false);
		//\ini_set('session.use_only_cookies', false);
		
		//\session_name(self::SESSION_VAR);
		
		//echo '<p>Session-Name: ' . \session_name() . '</p>';
		
		dep::registerObject(interfaces\Page::class, $page);
		dep::registerObject(WidgetRegistry::class, $page->getWidgetRegistry());*/
	}
	
	
	
	
	
	public function execute() {
		$action = $this->request->query->get('nexxes_action', 'page');
		if (($action == 'page') && $this->request->isXmlHttpRequest()) {
			$action = 'json';
		}
		
		if (!isset($this->actionhandler[$action])) {
			throw new \InvalidArgumentException('Unknown action type: ' . $action);
		}
		
		$class = $this->actionhandler[$action];
		$handler = new $class($this);
		
		/* @var $response \Symfony\Component\HttpFoundation\Response */
		$response = $handler->execute();
		$response->send();
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
}
