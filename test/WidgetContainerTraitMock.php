<?php

namespace nexxes\widgets;

/**
 * @author Dennis Birkholz <dennis.birkholz@nexxes.net>
 */
class WidgetContainerTraitMock implements WidgetContainerInterface {
	use WidgetContainerTrait;
	
	public function __toString() {
	}
}
