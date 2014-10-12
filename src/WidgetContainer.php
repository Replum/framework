<?php

namespace nexxes\widgets;

/**
 * @author Dennis Birkholz <dennis.birkholz@nexxes.net>
 */
class WidgetContainer implements WidgetContainerInterface {
	use WidgetContainerTrait;
	
	public function __construct(WidgetInterface $parent = null) {
		if ($parent !== null) { $this->setParent($parent); }
	}
	
	public function __toString() {
		return '<' . $this->escape($this->getTag()) . $this->renderAttributes() . '>' . PHP_EOL . $this->renderChildren() . '</' . $this->escape($this->getTag()) . '>';
	}
}
