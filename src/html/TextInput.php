<?php

namespace nexxes\widgets\html;

use \nexxes\widgets;

/**
 * Description of TextInput
 *
 * @author dennis
 */
class TextInput implements widgets\HTMLWidgetInterface, IdentifiableInterface {
	use widgets\WidgetTrait, widgets\IdentifiableTrait, widgets\HTMLWidgetTrait;
	
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
	
	
	public function __toString() {
		return '<input type="text"'
			. $this->getIDHTML()
			. $this->getClassesHTML()
			. $this->getTabIndexHTML()
			. $this->getTitleHTML()
			
			. $this->getNameHTML()
			. $this->getValueHTML()
			
			. ' onchange="nexxes.widgets.onchange(this);"'
			. ' />';
	}
}
