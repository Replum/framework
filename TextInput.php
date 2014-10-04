<?php

namespace nexxes\widgets\html;

use \nexxes\widgets\WidgetTrait;
use \nexxes\widgets\WidgetHasChangeEventInterface;
use \nexxes\widgets\WidgetHasEventsTrait;
use \nexxes\widgets\WidgetHasChangeEventTrait;

/**
 * @author Dennis Birkholz <dennis.birkholz@nexxes.net>
 */
class TextInput implements FormElementInterface, WidgetHasChangeEventInterface {
	use WidgetTrait, FormElementTrait, WidgetHasEventsTrait, WidgetHasChangeEventTrait;
	
	/**
	 * @var string
	 */
	private $name;
	
	/**
	 * @param string $newName
	 * @return \nexxes\widgets\html\TextInput $this for chaining
	 */
	public function setName($newName) {
		$this->name = $newName;
		return $this;
	}
	
	public function getName() {
		return $this->name;
	}
	
	protected function getNameHTML() {
		return (\is_null($this->name) ? '' : ' name="' . $this->escape($this->name) . '"');
	}
	
	
	/**
	 * @var string
	 */
	private $value;
	
	/**
	 * @param string $newValue
	 * @return \nexxes\widgets\html\TextInput $this for chaining
	 */
	public function setValue($newValue) {
		$this->value = $newValue;
		return $this;
	}
	
	public function getValue() {
		return $this->value;
	}
	
	protected function getValueHTML() {
		return (\is_null($this->value) ? '' : ' value="' . $this->escape($this->value) . '"');
	}
	
	
	public function __toString() {
		return '<input type="text"'
			. $this->getAttributesHTML()
			
			. $this->renderChangeHandlerHTML()
			
			. $this->getNameHTML()
			. $this->getValueHTML()
			
			. ' />';
	}
}
