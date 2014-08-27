<?php

namespace nexxes\widgets\html;

use \nexxes\widgets;

class Form implements widgets\WidgetContainerInterface {
	use widgets\WidgetContainerTrait, widgets\WidgetTrait;
	
	public function __toString() {
		$r = '<form role="form"'
			. $this->getAttributesHTML()
			. '>' . "\n";
		
		foreach ($this AS $widget) {
			$r .= $widget . "\n";
		}
		
		$r .= '</form>' . "\n";
		
		return $r;
	}
}
