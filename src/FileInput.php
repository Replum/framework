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

use \nexxes\widgets\WidgetInterface;
use \nexxes\widgets\WidgetTrait;
use \nexxes\widgets\WidgetHasChangeEventInterface;
use \nexxes\widgets\WidgetHasChangeEventTrait;

/**
 * @author Dennis Birkholz <dennis.birkholz@nexxes.net>
 */
class FileInput implements FormElementInterface, WidgetHasChangeEventInterface {
	use WidgetTrait,  WidgetHasChangeEventTrait;
	use FormInputTrait {
		hasAutocomplete as public;
		enableAutocomplete as public;
		disableAutocomplete as public;
		unsetAutocomplete as public;
		
		hasAutofocus as public;
		enableAutofocus as public;
		disableAutofocus as public;
		
		getMinlength as public;
		setMinlength as public;
		
		getMaxlength as public;
		setMaxlength as public;
		
		getPlaceholder as public;
		setPlaceholder as public;
		
		isReadonly as public;
		enableReadonly as public;
		disableReadonly as public;
		
		isRequired as public;
		enableRequired as public;
		disableRequired as public;
	}
	
	/**
	 * @var string
	 * @link http://www.w3.org/TR/html5/forms.html#attr-input-accept
	 */
	private $accept;
	
	/**
	 * @return string
	 * @link http://www.w3.org/TR/html5/forms.html#attr-input-accept
	 */
	public function getAccept() {
		return $this->accept;
	}
	
	/**
	 * @param string $newAccept
	 * @return \nexxes\widgets\html\Input $this for chaining
	 * @link http://www.w3.org/TR/html5/forms.html#attr-input-accept
	 */
	public function setAccept($newAccept) {
		$this->accept = $newAccept;
		return $this;
	}
	
	/**
	 * @return string
	 */
	protected function renderAcceptAttribute() {
		return (!\is_null($this->accept) ? ' accept="' . $this->escape($this->accept) . '"' : '');
	}
	
	public function __construct(WidgetInterface $parent = null) {
		if (!is_null($parent)) { $this->setParent($parent); }
		$this->setType('file');
	}
	
	
	public function __toString() {
		return '<input'
			. $this->renderAttributes()
			. $this->renderFormInputAttributes()
			. ' />';
	}
}
