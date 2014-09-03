<?php

namespace nexxes\widgets\pagedef\structure;

/**
 * @author Dennis Birkholz <dennis.birkholz@nexxes.net>
 */
class Slot extends Widget {
	/**
	 * The slot name to use
	 * @var string
	 */
	public $name;
	
	/**
	 * Slot is a WidgetContainer, append to it
	 * @var bool
	 */
	public $append = false;
	
	/**
	 * @param string $class
	 * @param string $name
	 * @param bool $append
	 */
	public function __construct($class, $name, $append) {
		parent::__construct($class);
		$this->name = $name;
		$this->append = $append;
	}
	
	public function generateCode($parent, array $prefix, $name) {
		return '$' . \implode('_', $prefix) . '[' . \var_export($this->name, true) . ']' . ($this->append ? '[]' : '') . ' = '
			. parent::generateCode($parent, $prefix, $this->name . ($this->append ? $name : ''));
	}
}
