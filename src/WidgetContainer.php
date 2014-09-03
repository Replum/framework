<?php

namespace nexxes\widgets;

/**
 * @author Dennis Birkholz <dennis.birkholz@nexxes.net>
 */
class WidgetContainer implements WidgetContainerInterface {
	use WidgetContainerTrait;
	
	public function __construct(WidgetInterface $parent) {
		$this->setParent($parent);
	}
	
	public function __toString() {
		return '<' . $this->escape($this->getType()) . $this->getAttributesHTML() . '>' . PHP_EOL . $this->renderChildrenHTML() . '</' . $this->escape($this->getType()) . '>';
	}
}
