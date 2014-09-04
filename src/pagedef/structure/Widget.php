<?php

namespace nexxes\widgets\pagedef\structure;

/**
 * @author Dennis Birkholz <dennis.birkholz@nexxes.net>
 */
class Widget {
	/**
	 * The fully qualified class name to use
	 * @var string
	 */
	public $class;
	
	/**
	 * List of properties to set for this object
	 * @var array<Property>
	 */
	public $properties = [];
	
	/**
	 * List of widgets to append as children
	 * @var array<Widget>
	 */
	public $children = [];
	
	/**
	 * List of widgets to put into slots
	 * @var array<Widget>
	 */
	public $slots = [];
	
	/**
	 * Save a shortcut reference to this widget in the page
	 * @var string
	 */
	public $ref;
	
	/**
	 * @param string $class The class name of the widget
	 */
	public function __construct($class) {
		$this->class = $class;
	}
	
	/**
	 * Add a child, slot or property to this widget
	 * 
	 * @param Child|Slot|Property $data
	 * @return \nexxes\widgets\pagedef\structure\Widget $this for chaining
	 */
	public function add($data) {
		$args = \func_get_args();
		
		foreach ($args AS $arg) {
			if ($arg instanceof Property) {
				$this->properties[] = $arg;
			} elseif ($arg instanceof Child) {
				$this->children[] = $arg;
			} elseif ($arg instanceof Slot) {
				$this->slots[] = $arg;
			} else {
				throw new \InvalidArgumentException('Invalid data: "' . \var_export($arg, true) . '"');
			}
		}
		
		return $this;
	}
	
	/**
	 * Set the ref
	 * @param string $ref
	 * @return \nexxes\widgets\pagedef\structure\Widget $this for chaining
	 */
	public function ref($ref) {
		$this->ref = $ref;
		return $this;
	}
	
	public function generateCode($parent, array $prefix, $name) {
		$parentVar = '$' . \implode('_', $prefix);
		$prefix[] = $name;
		$currentVar = '$' . \implode('_', $prefix);
		
		$r = '';
			
		if (\count($this->properties)) {
			$r .= $currentVar . PHP_EOL;
			
			foreach ($this->properties AS $property) {
				$r .= "\t" . $property->generateCode($this, $prefix) . PHP_EOL;
			}
			
			$r .= ';' . PHP_EOL;
		}
		
		foreach ($this->children AS $i => $child) {
			$r .= $child->generateCode($this, $prefix, $i);
		}
		
		foreach ($this->slots AS $i => $slot) {
			$r .= $slot->generateCode($this, $prefix, $i);
		}
		
		if ($parent === null) {
			return 'return function(\\nexxes\\widgets\\WidgetInterface $root) {' . PHP_EOL . $r . '};' . PHP_EOL;
		} else {
			return ($this->ref !== null ? '$root->' . $this->ref . ' = ' : '')
				. $currentVar . ' = new ' . $this->class . '(' . $parentVar . ');' . PHP_EOL . $r;
		}
	}
}
