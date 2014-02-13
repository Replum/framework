<?php

namespace nexxes;

use \nexxes\PageContext;

class Page extends Widget implements iPage {
	public function __construct() {
		echo "The Page constructor<br>\n";
		
		$this->id = PageContext::$widgetRegistry->pageID;
	}
	
	public function persist() {
		echo "Persisting data ...<br>\n";
		flush();
		$data = \serialize($this);
		\apc_store(PageContext::$widgetRegistry->pageID, $data);
	}
}
