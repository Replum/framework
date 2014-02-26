<?php

namespace nexxes\widgets;

use \nexxes\property\Config;

class ListGroupItem extends \nexxes\WidgetContainer {
	/**
	 * @var string
	 * @Config(type="string", match="/^(success|info|warning|danger)$/")
	 */
	public $status;
	
	
	public function renderHTML() {
		$this->addClass('list-group-item');
		foreach (['success', 'info', 'warning', 'danger'] AS $status) {
			if ($this->status == $status) {
				$this->addClass('list-group-item-' . $status);
			} else {
				$this->delClass('list-group-item-' . $status);
			}
		}
		
		return '<li ' . $this->renderCommonAttributes() . '>' . $this->renderChildrenHTML() . '</li>' . PHP_EOL;
	}
}
