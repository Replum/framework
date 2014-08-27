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
	
	
	
	
	/**
	 * @var array<callable>
	 */
	private $actionhandler = [];
	
	public function registerAction($actionName, callable $handler) {
		$this->actionhandler[$actionName] = $handler;
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
		
		$this->registerAction('page', function(Executer $exec) { return [new \nexxes\widgets\actionhandler\PageHandler($exec), 'execute']; });
		$this->registerAction('json', function(Executer $exec) { return [new \nexxes\widgets\actionhandler\JsonHandler($exec), 'execute']; });
		$this->registerAction('vendor', function(Executer $exec) { return [new \nexxes\widgets\actionhandler\VendorHandler($exec), 'execute']; });
	}
	
	public function execute() {
		$action = $this->request->query->get('nexxes_action', 'page');
		if (($action == 'page') && $this->request->isXmlHttpRequest()) {
			$action = 'json';
		}
		
		if (!isset($this->actionhandler[$action])) {
			throw new \InvalidArgumentException('Unknown action type: ' . $action);
		}
		
		$handler = $this->actionhandler[$action]($this);
		
		/* @var $response \Symfony\Component\HttpFoundation\Response */
		$response = $handler();
		$response->send();
	}
}
