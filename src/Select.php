<?php

/*
 * This file is part of the nexxes/widgets-html package.
 * 
 * Copyright (c) Dennis Birkholz, nexxes Informationstechnik GmbH <dennis.birkholz@nexxes.net>
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace nexxes\widgets\html;

use \nexxes\widgets\WidgetTrait;
use \nexxes\widgets\WidgetHasChangeEventInterface;
use \nexxes\widgets\WidgetHasChangeEventTrait;

/**
 * @author Dennis Birkholz <dennis.birkholz@nexxes.net>
 */
class Select implements WidgetHasChangeEventInterface, FormInputInterface {
	use WidgetTrait, WidgetHasChangeEventTrait, FormElementTrait;
	
	/**
	 * @var string
	 * @link http://www.w3.org/TR/html5/forms.html#attr-fe-name
	 */
	private $name;
	
	/**
	 * @return string
	 * @link http://www.w3.org/TR/html5/forms.html#attr-fe-name
	 */
	public function getName() {
		return $this->name;
	}
	
	/**
	 * @param string $newName
	 * @return \nexxes\widgets\html\Input $this for chaining
	 * @link http://www.w3.org/TR/html5/forms.html#attr-fe-name
	 */
	public function setName($newName) {
		if ($this->name !== $newName) {
			$this->name = $newName;
			$this->setChanged();
		}
		return $this;
	}
	
	/**
	 * Helper function to render the the name attribute
	 * @return string
	 */
	protected function renderNameAttribute() {
		return (\is_null($this->name) ? '' : ' name="' . $this->escape($this->name) . '"');
	}
	
	private $values;
	
	public function getValues() {
		return $this->values;
	}
	
	/**
	 * @param array $values
	 * @return \nexxes\widgets\html\Select
	 */
	public function setValues($values) {
		if ($this->values !== $values) {
			$this->values = $values;
			$this->setChanged(true);
		}
		return $this;
	}
	
	private $value;
	
	public function getValue() {
		return $this->value;
	}
	
	public function setValue($newValue) {
		if ($this->value !== $newValue) {
			$this->value = $newValue;
			$this->setChanged(true);
		}
		return $this;
	}
	
	public function __toString() {
		$r = '<select'
			. $this->renderAttributes()
			. $this->renderNameAttribute()
			. '>';
		
		$assoc = (\array_keys($this->values) !== \range(0, \count($this->values) - 1));
		
		foreach ($this->values as $key => $value) {
			$r .= '<option'
				. ($assoc ? ' value="' . $this->escape($key) . '"' : '')
				. ($assoc && ($this->value === $key) ? ' selected=selected' : '')
				. (!$assoc && ($this->value === $value) ? ' selected=selected' : '')
				. '>'
				. $this->escape($value)
				. '</option>';
		}
		
		$r .= '</select>';
		
		return $r;
	}
}
