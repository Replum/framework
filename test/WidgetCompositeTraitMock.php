<?php

namespace nexxes\widgets;

/**
 * @author Dennis Birkholz <dennis.birkholz@nexxes.net>
 */
class WidgetCompositeTraitMock implements WidgetCompositeInterface {
	use WidgetCompositeTrait;
	
	public function __toString() {
	}
}
