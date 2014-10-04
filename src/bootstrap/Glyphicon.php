<?php

namespace nexxes\widgets\bootstrap;

use \nexxes\widgets\WidgetInterface;
use \nexxes\widgets\WidgetTrait;

/**
 * This class represents a glyphicon icon.
 * A glyphicon should not contain other classes and must be empty to work the desired way.
 * 
 * @author Dennis Birkholz <dennis.birkholz@nexxes.net>
 * @see http://getbootstrap.com/components/#glyphicons
 * @see http://glyphicons.com/
 */
class Glyphicon implements WidgetInterface {
	use WidgetTrait;
	
	/**
	 * @var string
	 */
	private $name;
	
	/**
	 * @return string
	 */
	public function getName() {
		return $this->name;
	}
	
	/**
	 * @param string $newName
	 * @return \nexxes\widgets\bootstrap\Glyphicon $this for Chaining
	 */
	public function setName($newName) {
		if ($this->name !== $newName) {
			$this->name = $newName;
			$this->setChanged(true);
		}
		
		return $this;
	}
	
	public function __toString() {
		$this->delClass('/^glyphicon-/');
		$this->addClass('glyphicon');
		$this->addClass('glyphicon-' . $this->name);
		
		return '<span ' . $this->getAttributesHTML() . '></span>' . PHP_EOL;
	}
}
