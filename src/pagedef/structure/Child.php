<?php

namespace nexxes\widgets\pagedef\structure;

/**
 * @author Dennis Birkholz <dennis.birkholz@nexxes.net>
 */
class Child extends Widget {
	public function generateCode($parent, array $prefix, $name) {
		return parent::generateCode($parent, $prefix, 'child' . $name);
	}
}
