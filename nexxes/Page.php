<?php

namespace nexxes;

use \nexxes\PageContext;
use \nexxes\property\Config;

abstract class Page extends WidgetContainer implements iPage {
	/**
	 * The page title
	 * 
	 * @var string
	 * @Config(type="string")
	 */
	public $title;
	
	public function __construct() {
		$this->id = PageContext::$widgetRegistry->pageID;
	}
	
	public function render() {
		print $this->renderHTML();
	}	
	
	public function renderHTML() {
		$s = $this->smarty();
		$s->assign('page', $this);
		return $s->fetch(__DIR__ . '/Page.tpl');
	}
}
