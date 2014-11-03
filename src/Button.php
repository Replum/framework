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

use \nexxes\widgets\WidgetContainerInterface;
use \nexxes\widgets\WidgetContainerTrait;
use \nexxes\widgets\WidgetHasClickEventInterface;
use \nexxes\widgets\WidgetHasClickEventTrait;

/**
 * @author Dennis Birkholz <dennis.birkholz@nexxes.net>
 */
class Button implements WidgetContainerInterface, FormElementInterface, WidgetHasClickEventInterface {
	use WidgetContainerTrait, WidgetHasClickEventTrait;
	use FormInputTrait {
		setType as public;
	}
	
	public function __toString() {
		return '<' . $this->getTag() . $this->renderAttributes() . '>' . $this->renderChildren() . '</button>' . PHP_EOL;
	}
	
	/**
	 * {@inheritdoc}
	 */
	protected function validTags() {
		return [ 'button' ];
	}
	
	/**
	 * {@inheritdoc}
	 */
	protected function renderAttributes() {
		return $this->renderWidgetAttributes()
			. $this->renderFormInputAttributes()
		;
	}
}
