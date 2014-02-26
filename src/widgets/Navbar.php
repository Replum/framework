<?php

namespace nexxes\widgets;

use \nexxes\property\Config;

class Navbar extends \nexxes\WidgetContainer {
	/**
	 * @var string
	 * @Config(type="string", match="/^(default|inverted)$/")
	 */
	public $style = "default";
	
	/**
	 * @var string
	 * @Config(type="string", match="/^(top|bottom)$/")
	 */
	public $position = "top";
	
	/**
	 * @var bool
	 * @Config(type="bool")
	 */
	public $fixed = true;
	
	/**
	 * Page brand to show in navbar
	 * 
	 * @var string
	 * @Config(type="string")
	 */
	public $brand;
	
	/**
	 * Link to the home page
	 * 
	 * @var string
	 * @Config(type="string")
	 */
	public $homeurl = '/';
	
	
	
	public function __construct() {
		parent::__construct();
		
		$this->role = 'navigation';
		$this->addClass('navbar');
		$this->addClass('navbar-' . $this->style);
		$this->addClass('navbar-' . ($this->fixed ? 'fixed' : 'static') . '-' . $this->position);
	}
}
