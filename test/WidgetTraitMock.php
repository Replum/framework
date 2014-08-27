<?php

namespace nexxes\widgets;

/**
 * @author Dennis Birkholz <dennis.birkholz@nexxes.net>
 */
class WidgetTraitMock implements WidgetInterface {
	use WidgetTrait;
	
	public function __toString() {
		return "";
	}
}
