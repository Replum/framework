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

/**
 * @author Dennis Birkholz <dennis.birkholz@nexxes.net>
 * @link http://www.w3.org/TR/html5/forms.html#the-label-element
 */
class Label extends WidgetContainer {
	/**
	 * {@inheritdoc}
	 */
	public function validTypes() {
		return [ 'label' ];
	}
	
	/**
	 * Restrict allowed children for label elements 
	 * @param mixed $widget
	 */
	protected function validateWidget($widget) {
		if (!($widget instanceof PhrasingContentInterface)) {
			throw new \InvalidArgumentException(\get_class($this) . ' can only contain elements implementing the ' . PhrasingContentInterface::class . ' interface');
		}
	}
	
	
	/**
	 * The element this label is for
	 * @var FormElementInterface
	 */
	private $htmlFor;
	
	/**
	 * @return FormElementInterface
	 */
	public function getFor() {
		return $this->htmlFor;
	}
	
	/**
	 * @param \nexxes\widgets\html\FormElementInterface $element
	 * @return \nexxes\widgets\html\Label $this for chaining
	 */
	public function setFor(FormElementInterface $element) {
		if ($element !== $this->htmlFor) {
			$this->setChanged(true);
		}
		
		$this->htmlFor = $element;
		return $this;
	}
	
	
	/**
	 * Add for attribute when printing
	 * @return string
	 */
	protected function getAttributesHTML() {
		return ($this->getFor() !== null ? ' for="' . $this->escape($this->getFor()->getID()) . '"' : '')
			. parent::getAttributesHTML();
	}
}
