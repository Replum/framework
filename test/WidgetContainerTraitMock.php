<?php

namespace nexxes\widgets;

/**
 * @author Dennis Birkholz <dennis.birkholz@nexxes.net>
 */
class WidgetContainerTraitMock implements WidgetContainerInterface {
	use WidgetContainerTrait;
	
	public function __construct(WidgetInterface $parent) {
		$this->setParent($parent);
	}
	
	public function __toString() {
	}
}
