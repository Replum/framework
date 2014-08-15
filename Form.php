<?php

namespace nexxes\widgets\html;

use \nexxes\widgets;

class Form implements widgets\HTMLWidgetInterface, widgets\WidgetContainerInterface {
	use widgets\WidgetContainerTrait, widgets\HTMLWidgetTrait, widgets\IdentifiableTrait, widgets\WidgetTrait;
	
	public function __toString() {
		$r = '<form role="form"'
			. $this->getClassesHTML()
			. $this->getIDHTML()
			. $this->getTabIndexHTML()
			. $this->getTitleHTML()
			. '>' . "\n";
		
		foreach ($this AS $widget) {
			$r .= $widget . "\n";
		}
		
		$r .= '</form>' . "\n";
		
		return $r;
	}
}
