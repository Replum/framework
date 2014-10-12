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
 * @property boolean $checked Checkbox is activated or not
 * @property boolean $required Element must be filled.
 */
class Checkbox implements FormElementInterface, WidgetHasChangeEventInterface {
	use WidgetTrait,  WidgetHasChangeEventTrait;
	use FormInputTrait {
		isChecked as public;
		enableChecked as public;
		disableChecked as public;
		
		isRequired as public;
		enableRequired as public;
		disableRequired as public;
	}
	
	public function __construct(WidgetInterface $parent = null) {
		if (!is_null($parent)) { $this->setParent($parent); }
		$this->setType('checkbox');
	}
	
	
	public function __toString() {
		return '<input'
			. $this->renderAttributes()
			. $this->renderFormInputAttributes()
			
			. $this->renderChangeHandler()
			. ' />';
	}
}
