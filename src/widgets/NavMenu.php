<?php

namespace nexxes\widgets;

use \nexxes\property\Config;

class NavMenu extends \nexxes\WidgetContainer {
	/**
	 * @var string
	 * @Config(type="string", match="/^(left|right)$/")
	 */
	public $position;
	
	
	
	
	public function renderHTML() {
		$this->addClass('nav');
		$this->addClass('navbar-nav');
		
		if ($this->position) {
			$this->addClass('navbar-' . $this->position);
		}
		
		return parent::renderHTML();
	}
}
