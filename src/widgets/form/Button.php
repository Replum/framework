<?php

namespace nexxes\widgets\form;

use \nexxes\property\Config;

class Button extends \nexxes\Widget {
	/**
	 *
	 * @var string
	 * @Config(type="string")
	 */
	public $type;
	
	/**
	 * Detailed description
	 * 
	 * @var string
	 * @Config(type="string")
	 */
	public $tooltip;
	
	/**
	 * Tooltip placement
	 * 
	 * @var string left|right|top|bottom
	 * @Config(type="string")
	 */
	public $placement;
	
	/**
	 * The value/contents of the field
	 * 
	 * @var string
	 * @Config(type="string", fill=true)
	 */
	public $value;
	
	/**
	 * Additional classes for this element
	 * 
	 * @var array<string>
	 * @Config(type="string", array=true)
	 */
	public $classes = [];
	
	
	public function __construct($value = '', $type = "submit", $tooltip = null) {
		parent::__construct();
		
		$this->value = $value;
		$this->type = $type;
		$this->tooltip = $tooltip;
	}
	
	
	public function renderHTML() {
		$s = $this->smarty();
		return $s->fetch(__DIR__ . '/Button.tpl');
	}
}
