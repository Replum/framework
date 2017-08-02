<?php

namespace nexxes\widgets;

/**
 * @author Dennis Birkholz <dennis.birkholz@nexxes.net>
 */
class WidgetCompositeTraitMock implements WidgetCompositeInterface {
	use WidgetCompositeTrait;
	
	public function __construct(WidgetContainerInterface $parent = null) {
		if (!is_null($parent)) { $this->setParent($parent); }
	}
	
	public function __toString() {
	}
}
