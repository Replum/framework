<?php

namespace nexxes\widgets;

use \nexxes\property\Config;

class ListGroup extends \nexxes\WidgetContainer implements iPanelChild {
	public function addWidget(\nexxes\iWidget $child) {
		if (!($child instanceof ListGroupItem)) {
			throw new \InvalidArgumentException('Can only add list group items to a list group!');
		}
		
		parent::addWidget($child);
	}
	
	public function renderHTML() {
		$this->addClass('list-group');
		return '<ul ' . $this->renderCommonAttributes() . '>' . $this->renderChildrenHTML() . '</ul>';
	}
}
