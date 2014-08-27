<?php

namespace nexxes\widgets\html;

use \nexxes\widgets;

/**
 * The FormElement is the base class for all 
 * 
 * @author Dennis Birkholz <dennis.birkholz@nexxes.net>
 */
abstract class FormElement implements FormElementInterface {
	use widgets\WidgetTrait, widgets\HTMLWidgetTrait, widgets\IdentifiableTrait, widgets\WidgetHasChangeEventTrait, widgets\WidgetHasEventsTrait;
	
	/**
	 * {@inheritdoc}
	 */
	public function getForm() {
		$parent = $this->getParent();
		
		while (!is_null($parent)) {
			if ($parent instanceof Form) {
				return $parent;
			}
			
			// No parent
			if ($parent->isRoot()) {
				break;
			}
			
			$parent = $this->getParent();
		}
		
		throw new \RuntimeException('FormElement has no form containing it!');
	}
}
