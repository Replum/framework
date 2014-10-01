<?php

namespace nexxes\widgets\html;

use \nexxes\widgets\WidgetHasChangeEventInterface;
use \nexxes\widgets\WidgetHasChangeEventTrait;
use \nexxes\widgets\WidgetHasEventsTrait;
use \nexxes\widgets\WidgetInterface;
use \nexxes\widgets\WidgetTrait;

/**
 * @author Dennis Birkholz <dennis.birkholz@nexxes.net>
 */
class DateInput extends FormElement implements WidgetHasChangeEventInterface {
	use WidgetTrait, WidgetHasChangeEventTrait, WidgetHasEventsTrait;
	
	/**
	 * @var string
	 */
	private $name;
	
	/**
	 * @param string $newName
	 * @return \nexxes\widgets\html\DateInput $this for chaining
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
	 * @return \nexxes\widgets\html\DateInput $this for chaining
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
	 * @param \nexxes\widgets\WidgetInterface $parent
	 * @param string $name
	 */
	public function __construct(WidgetInterface $parent) {
		$this->setParent($parent);
		$this->setID();
		
		$this->setData('provide', 'datepicker');
		$this->setData('dateLanguage', 'de-DE');
	}
	
	
	public function __toString() {
		return '<input type="date"'
			. $this->getAttributesHTML()
			
			. $this->renderChangeHandlerHTML()
			
			. $this->getNameHTML()
			. $this->getValueHTML()
			
			. ' />';
	}
}