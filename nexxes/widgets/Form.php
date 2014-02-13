<?php

namespace nexxes\widgets;

use \nexxes\property\Config;

class Form extends \nexxes\WidgetContainer {
	/**
	 *
	 * @var string
	 * @Config(type="string")
	 */
	public $title;
	
	/**
	 * @var \nexxes\widgets\form\ButtonList
	 */
	protected $buttons;
	
	public function renderHTML() {
		$s = $this->smarty();
		return $s->fetch(__DIR__ . '/Form.tpl');
	}
	
	public function addButton(\nexxes\widgets\form\Button $button) {
		if (!isset($this->buttons)) {
			$this->buttons = new \nexxes\widgets\form\ButtonList();
			$this->add($this->buttons);
		}
		$this->buttons->add($button);
	}
}
