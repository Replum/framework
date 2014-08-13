<?php

namespace nexxes\widgets\traits;

class WidgetCompositeMock implements \nexxes\widgets\interfaces\WidgetComposite {
	use WidgetComposite, Widget;
	
	public function renderHTML() {
	}
}
