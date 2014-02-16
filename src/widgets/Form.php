<?php

namespace nexxes\widgets;

use \nexxes\property\Config;

class Form extends \nexxes\WidgetContainer {
	/**
	 * @var string
	 * @Config(type="string")
	 */
	public $title;
	
	/**
	 * @var \nexxes\widgets\form\ButtonList
	 */
	protected $buttons;
	
	/**
	 * HTML classes for the outer element
	 * 
	 * @var array<string>
	 * @Config(type="string", array=true)
	 */
	public $classes = [];
	
	/**
	 * Layout style of the form:
	 * - default: vertical orientation, label, field, label, etc.
	 * - inline: no line wraps
	 * - horizontal: label and field in one line
	 * - left: part of a nav-bar, left orientation
	 * - right: part of a nav-bar, right orientation
	 * 
	 * @var string 
	 * @Config(type="string", match="/^(inline|horizontal|left|right)$/")
	 */
	public $layout;
	
	/**
	 *
	 * @var string
	 * @Config(type="string")
	 */
	public $errortitle;
	
	/**
	 *
	 * @var array<string>
	 * @Config(type="string", array=true)
	 */
	public $errors = [];
	
	
	
	public function __construct() {
		parent::__construct();
		$this->role = 'form';
	}
	
	
	
	public function renderHTML() {
		$this->addClass('nexxesSimpleWidget');
		if ($this->layout) {
			$this->addClass('form-' . $this->layout);
		}
		
		$s = $this->smarty();
		return $s->fetch(__DIR__ . '/Form.tpl');
	}
	
	public function addButton(\nexxes\widgets\form\Button $button) {
		if (!isset($this->buttons)) {
			$this->buttons = new \nexxes\widgets\form\ButtonList();
			$this->addWidget($this->buttons);
		}
		$this->buttons->addWidget($button);
	}
}
