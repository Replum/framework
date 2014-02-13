<?php

namespace nexxes\widgets\form;

class ButtonList extends \nexxes\WidgetContainer {
	public function renderHTML() {
		$s = $this->smarty();
		return $s->fetch(__DIR__ . '/ButtonList.tpl');
	}
}
