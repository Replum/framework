<?php

namespace nexxes\widgets;

class WidgetContainer implements interfaces\WidgetContainer {
	use traits\Widget, traits\WidgetContainer;
	
	public function __toString() {
		$r = '';
		foreach ($this AS $child) {
			$r .= $child;
		}
		return $r;
	}
}
