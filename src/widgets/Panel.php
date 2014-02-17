<?php

namespace nexxes\widgets;

use \nexxes\property\Config;

class Panel extends \nexxes\WidgetContainer {
	/**
	 * @var string
	 * @Config(type="string", match="/^(default|primary|success|info|warning|danger)$/")
	 */
	public $style = 'default';
	
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
		foreach (['default', 'primary', 'success', 'info', 'warning', 'danger',] AS $style) {
			if ($this->style == $style) {
				$this->addClass('panel-' . $style);
			} else {
				$this->delClass('panel-' . $style);
			}
		}
		
		return $this->renderDefaultHTML();
	}
}
