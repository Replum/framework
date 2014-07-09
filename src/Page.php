<?php

namespace nexxes\widgets;

use \nexxes\PageContext;
use \nexxes\property\Config;

abstract class Page extends WidgetContainer implements interfaces\Page {
	/**
	 * The page title
	 * 
	 * @var string
	 * @Config(type="string")
	 */
	public $title;
	
	protected $widgetRegistry;
	
	public function __construct() {
		$this->id = "page123";
		$this->widgetRegistry = new WidgetRegistry();
	}
	
	public function getWidgetRegistry() {
		return $this->widgetRegistry;
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
