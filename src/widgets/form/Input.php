<?php

namespace nexxes\widgets\form;

use \nexxes\property\Config;

class Input extends \nexxes\Widget {
	/**
	 * Field name
	 * 
	 * @var string
	 * @Config(type="string")
	 */
	public $caption;
	
	/**
	 * Detailed description
	 * 
	 * @var string
	 * @Config(type="string")
	 */
	public $tooltip;
	
	/**
	 * The value/contents of the field
	 * 
	 * @var string
	 * @Config(type="string", fill=true)
	 */
	public $value;
	
	/**
	 * Placeholder value to display if field is empty
	 * 
	 * @var string
	 * @Config(type="string")
	 */
	public $placeholder;
	
	/**
	 * The size of the input field
	 * 
	 * @var int
	 * @Config(type="int")
	 */
	public $size;
	
	/**
	 * Mark field as error
	 * 
	 * @var bool
	 * @Config(type="bool")
	 */
	public $error;
	
	/**
	 *
	 * @var string
	 * @Config(type="string")
	 */
	public $type;
	
	/**
	 * Additional classes for this element
	 * 
	 * @var array<string>
	 * @Config(type="string", array=true)
	 */
	public $classes = [];
	
	
	public function __construct($caption, $tooltip = null, $placeholder = null) {
		parent::__construct();
		
		$this->caption = $caption;
		$this->tooltip = $tooltip;
		$this->placeholder = $placeholder;
	}
	
	
	public function renderHTML() {
		$s = $this->smarty();
		return $s->fetch(__DIR__ . '/Input.tpl');
	}
}