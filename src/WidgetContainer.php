<?php

namespace nexxes\widgets;

class WidgetContainer implements WidgetContainerInterface {
	use WidgetTrait, WidgetContainerTrait;
	
	public function __toString() {
		$x = $this->getAttributesHTML();
		
		$r = '';
		foreach ($this AS $child) {
			$r .= $child;
		}
		
		return ($x !== '' ? '<div ' . $x . '>' . $r . '</div>' : $r);
	}
}
