<?php

namespace nexxes;

class Page extends Widget implements iPage {
	/**
	 * Central point for widgets
	 * 
	 * @var WidgetRegistry
	 */
	protected $registry;
	
	
	
	
	public function __construct() {
		$this->registry = new WidgetRegistry();
		$this->id = $this->registry->pageID;
	}
	
	public function persist() {
		echo "Persisting data ...<br>\n";
		flush();
		// Do not store context to avoid storing smarty, etc.
		unset($this->context);
		$data = \serialize($this);
		\apc_store($this->id, $data);
	}
}
