<?php

namespace nexxes\widgets\html;

use \nexxes\widgets\interfaces;
use \nexxes\widgets\traits;

class Form implements interfaces\HTMLWidget, interfaces\WidgetContainer {
	use traits\WidgetContainer, traits\HTMLWidget, traits\Identifiable, traits\Widget;
	
	public function __toString() {
		$r = '<form'
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
