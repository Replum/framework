<?php

namespace nexxes\widgets\traits;

class IdentifiableMock implements \nexxes\widgets\interfaces\Identifiable {
	use Widget, HTMLWidget, Identifiable;
	
	public function __toString() {
	}
}

