<?php

namespace nexxes\widgets;

class WidgetContainer implements WidgetContainerInterface, HTMLWidgetInterface, IdentifiableInterface {
	use WidgetTrait, WidgetContainerTrait, HTMLWidgetTrait, IdentifiableTrait;
	
	public function __toString() {
		$x = $this->getIDHTML()
			. $this->getClassesHTML()
			. $this->getTabIndexHTML()
			. $this->getTitleHTML();
		
		$r = '';
		foreach ($this AS $child) {
			$r .= $child;
		}
		
		return ($x !== '' ? '<div ' . $x . '>' . $r . '</div>' : $r);
	}
}
