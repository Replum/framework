<?php

namespace nexxes\widgets\bootstrap;

use \nexxes\widgets\WidgetInterface;
use \nexxes\widgets\HTMLWidgetInterface;

use \nexxes\widgets\WidgetTrait;
use \nexxes\widgets\HTMLWidgetTrait;

/**
 * This class represents a glyphicon icon.
 * A glyphicon should not contain other classes and must be empty to work the desired way.
 * 
 * @author Dennis Birkholz <dennis.birkholz@nexxes.net>
 * @see http://getbootstrap.com/components/#glyphicons
 * @see http://glyphicons.com/
 */
class Glyphicon implements WidgetInterface, HTMLWidgetInterface {
	use WidgetTrait, HTMLWidgetTrait;
	
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
	
	/**
	 * @param string $name The name of the icon to show (without the "glyphicon-" prefix
	 */
	public function __construct($name) {
		$this->name = $name;
	}
	
	public function __toString() {
		$this->delClass('/^glyphicon-');
		$this->addClass('glyphicon');
		$this->addClass('glyphicon-' . $this->name);
		
		return '<span '
			. $this->getClassesHTML()
			. $this->getTabIndexHTML()
			. $this->getTitleHTML()
			. '</span>';
	}
}