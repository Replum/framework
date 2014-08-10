<?php

namespace nexxes\widgets;

abstract class Page implements interfaces\Page {
	use traits\Page, traits\WidgetContainer, traits\Widget;
	
	
	public function __construct() {
		$this->widgetRegistry = new WidgetRegistry;
		
		$this->addScript((new \nexxes\widgets\html\ScriptLink)->setUrl('/vendor/nexxes/widgets-base/js/jquery-1.11.1.js'));
	}
	
	public function render() {
		print $this->renderHTML();
	}	
	
	public function renderHTML() {
		/* @var $smarty \Smarty */
		$smarty = clone \nexxes\dependency\Gateway::get(\Smarty::class);
		$smarty->assign('id', $this->id);
		$smarty->assign('page', $this);
		
		return $smarty->fetch(__DIR__ . '/Page.tpl');
	}
}
