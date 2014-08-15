<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace nexxes\widgets\actionhandler;

use \nexxes\dependency\Gateway as dep;
use \Symfony\Component\HttpFoundation\Response;

/**
 * @author Dennis Birkholz <dennis.birkholz@nexxes.net>
 */
class PageHandler {
	/**
	 * @var \nexxes\widgets\Executer
	 */
	private $executer;
	
	public function __construct(\nexxes\widgets\Executer $executer) {
		$this->executer = $executer;
	}
	
	public function execute() {
		$path = \rawurldecode($this->executer->getRequest()->getPathInfo());
		if ($path == '/') {
			$pagename = 'Index';
		} else {
			// Strip trailing /
			$pagename = \substr($path, 1);
		}
		
		$pagename = \str_replace('/', '\\', $pagename);
		
		// Get the name and class of the current page
		$class = $this->executer->getPageNamespace() . '\\' . $pagename;

		if (!\class_exists($class)) {
			phpinfo();
			throw new \InvalidArgumentException('Invalid page "' . $path . '"!');
		}
		
		/* @var $page \nexxes\widgets\interfaces\Page */
		$page = new $class();
		$page->id = $this->generatePageID();
		dep::registerObject(\nexxes\widgets\interfaces\Page::class, $page);
		
		$response = new Response((string)$page);
		
		\apc_store($this->executer->getCacheNamespace() . '.' . $page->id, $page, 0);
		
		return $response;
	}
	
	protected function generatePageID() {
		$length = 8;
		
		do {
			$r = new \nexxes\common\RandomString($length);
			$length++;
		} while (\apc_exists($this->executer->getCacheNamespace() . '.' . $r));
		
		return (string)$r;
	}
}