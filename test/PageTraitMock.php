<?php

namespace nexxes\widgets;

/**
 * @author Dennis Birkholz <dennis.birkholz@nexxes.net>
 */
class PageTraitMock implements PageInterface {
	use PageTrait, WidgetContainerTrait;

	public function __toString() {
		return "";
	}
}
