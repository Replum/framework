<?php

/*
 * This file is part of the nexxes/widgets package.
 *
 * Copyright (C) 2014 Dennis Birkholz <dennis.birkholz@nexxes.net>.
 *
 * This library is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Lesser General Public License as
 * published by the Free Software Foundation, either version 3 of
 * the License, or (at your option) any later version.
 *
 * This library is distributed in the hope that it will be useful, but
 * WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 * See the GNU Lesser General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public
 * License along with this library; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston,
 * MA 02110-1301  USA
 */

namespace nexxes\widgets\html;

use \nexxes\widgets\WidgetContainer;
use \nexxes\widgets\WidgetHasClickEventInterface;
use \nexxes\widgets\WidgetHasClickEventTrait;
use \nexxes\widgets\WidgetHasEventsTrait;

/**
 * @author Dennis Birkholz <dennis.birkholz@nexxes.net>
 */
class A extends WidgetContainer implements WidgetHasClickEventInterface {
	use WidgetHasEventsTrait, WidgetHasClickEventTrait;
	
	
	protected function validTypes() {
		return ['a'];
	}
	
	/**
	 * @var string
	 */
	private $href;
	
	/**
	 * @return string
	 */
	public function getHref() {
		return $this->href;
	}
	
	/**
	 * @param string $newHref
	 * @return \nexxes\widgets\html\A $this for chaining
	 */
	public function setHref($newHref) {
		if ($newHref !== $this->href) {
			$this->href = $newHref;
			$this->setChanged(true);
		}
		
		return $this;
	}
	
	protected function renderAttributes() {
		return parent::renderAttributes()
			. (!\is_null($this->href) ? ' href="' . $this->escape($this->href) . '"' : '')
			. $this->renderClickHandler();
	}
}
