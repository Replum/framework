<?php

namespace nexxes\widgets\traits;

class IdentifiableMock implements \nexxes\widgets\interfaces\Identifiable {
	use HTMLWidget, Identifiable;
	
	public function renderHTML() {
	}
}

