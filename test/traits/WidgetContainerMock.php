<?php

namespace nexxes\widgets\traits;

/**
 * Description of WidgetContainerMock
 *
 * @author dennis
 */
class WidgetContainerMock implements \nexxes\widgets\interfaces\WidgetContainer {
	use WidgetContainer, Widget;
	
	public function __toString() {
	}
}
