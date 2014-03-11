<?php

namespace nexxes\widgets;

use \nexxes\property\Config;

class Link extends \nexxes\WidgetContainer {
	/**
	 * @var string
	 * @Config(type="string")
	 */
	public $url;
	
	/**
	 * @var string
	 * @Config(type="string")
	 */
	public $target;
	
	
	
	
	public function __construct($url = '', $target = null) {
		parent::__construct();
		
		$this->url = $url;
		$this->target = $target;
	}
	
	public function renderHTML() {
		return '<a href="' . $this->url . '"' . ($this->target ? ' target="' . $this->target . '"' : '') . $this->renderCommonAttributes() . '>' . $this->renderChildrenHTML() . '</a>';
	}
}
