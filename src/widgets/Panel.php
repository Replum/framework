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
	}
	
	public function renderHTML() {
		foreach (['default', 'primary', 'success', 'info', 'warning', 'danger',] AS $alternative) {
			if ($this->alternative == $alternative) {
				$this->addClass('panel-' . $alternative);
			} else {
				$this->delClass('panel-' . $alternative);
			}
		}
		
		return $this->renderDefaultHTML();
	}
}
