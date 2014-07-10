<?php

namespace nexxes\widgets\traits;

class HTMLWidgetMock implements \nexxes\widgets\interfaces\HTMLWidget {
	use Widget;
	use HTMLWidget {
		getClassesHTML as public;
		getTabIndexHTML as public;
		getTitleHTML as public;
	}
	
	public function renderHTML() {
	}
}
