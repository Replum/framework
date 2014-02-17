<?php

namespace nexxes\widgets;

use \nexxes\property\Config;

class Panel extends \nexxes\WidgetContainer {
	/**
	 * @var string
	 * @Config(type="string", match="/^(default|primary|success|info|warning|danger)$/")
	 */
	public $alternative = 'default';
	
	/**
	 * @var array<\nexxes\iWidget>
	 * @Config(type="\nexxes\iWidget", array=true)
	 */
	public $head = [];
	
	/**
	 * @var array<\nexxes\iWidget>
	 * @Config(type="\nexxes\iWidget", array=true)
	 */
	public $foot = [];
	
	protected function initialize() {
		$this->addClass('panel');
		$this->addClass('panel-' . $this->alternative);
	}
	
	public function renderHTML() {
		return $this->renderDefaultHTML();
	}
}
