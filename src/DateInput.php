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

use \nexxes\widgets\WidgetHasChangeEventInterface;
use \nexxes\widgets\WidgetHasChangeEventTrait;
use \nexxes\widgets\WidgetHasEventsTrait;
use \nexxes\widgets\WidgetInterface;
use \nexxes\widgets\WidgetTrait;

/**
 * @author Dennis Birkholz <dennis.birkholz@nexxes.net>
 */
class DateInput implements FormElementInterface, WidgetHasChangeEventInterface {
	use WidgetTrait, FormElementTrait, WidgetHasEventsTrait, WidgetHasChangeEventTrait;
	
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
	
	protected function renderNameAttribute() {
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
	
	protected function renderValueAttribute() {
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
		$this->setData('dateAutoclose', '1');
	}
	
	
	public function __toString() {
		return '<input type="date"'
			. $this->renderAttributes()
			
			. $this->renderChangeHandler()
			
			. $this->renderNameAttribute()
			. $this->renderValueAttribute()
			
			. ' />';
	}
}
