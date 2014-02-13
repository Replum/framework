<?php

namespace nexxes;

/**
 * Very simple container to store widget id
 */
class WidgetIdentifier {
	/**
	 * Request the widget with this id
	 * 
	 * @var type 
	 */
	protected $id;
	
	public function __construct(iWidget $widget) {
		$this->id = $widget->id;
	}
	
	public function widget() {
		return \nexxes\PageContext::$widgetRegistry->getWidget($this->id);
	}
}
