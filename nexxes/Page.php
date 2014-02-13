<?php

namespace nexxes;

use \nexxes\PageContext;

abstract class Page extends WidgetContainer implements iPage {
	public function __construct() {
		$this->id = PageContext::$widgetRegistry->pageID;
	}
}
