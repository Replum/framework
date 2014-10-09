<?php

namespace nexxes\widgets\pagedef\structure;

/**
 * @author Dennis Birkholz <dennis.birkholz@nexxes.net>
 */
class Property {
	/**
	 * The name of the property
	 * @var string
	 */
	public $name;
	
	/**
	 * The property value or a widget definition 
	 * @var string|Widget
	 */
	public $value;
	
	/**
	 * @param string $name The property name
	 * @param string|Widget $value The property value
	 */
	public function __construct($name, $value) {
		$this->name = $name;
		$this->value = $value;
	}
	
	public function generateCode(Widget $parent, array $prefix) {
		$parentVar = '$' . \implode('_', $prefix);
		
		$r = '';
		
		if ($this->value instanceof Widget) {
			$r .= $this->value->generateCode($parent, $prefix, $this->name);
			$value = '$' . \implode('_', \array_merge($prefix, [$this->name]));
		} else {
			$value = \var_export($this->value, true);
		}
		
		if (\method_exists($parent->class, 'add' . \ucfirst($this->name))) {
			return $r . $parentVar . '->add' . \ucfirst($this->name) . '(' . $value . ');' . PHP_EOL;
		}
		
		elseif (\method_exists($parent->class, 'set' . \ucfirst($this->name))) {
			return $r . $parentVar . '->set' . \ucfirst($this->name) . '(' . $value . ');' . PHP_EOL;
		}
		
		else {
			try {
				// Throws if no property is found
				$reflectionProperty = (new \ReflectionClass($parent->class))->getProperty($this->name);
				if ($reflectionProperty->isPublic()) {
					return $r . $parentVar . '->' . $this->name . ' = ' . $value . ';' . PHP_EOL;
				}
				
				else {
					$r .= '$reflectionObject = new \\ReflectionObject(' . $parentVar . ');' . PHP_EOL;
					$r .= '$reflectionProperty = $reflectionObject->getProperty("' . $this->name . '");' . PHP_EOL;
					$r .= '$reflectionProperty->setAccessible(true);' . PHP_EOL;
					$r .= '$reflectionProperty->setValue(' . $parentVar . ', ' . $value . ');' . PHP_EOL;
					return $r;
				}
			}
			
			catch (\ReflectionException $e) {
				throw new \InvalidArgumentException('No accessible setter for property "' . $this->name . '" in class "' . $parent->class . '" found.');
			}
		}
	}
}
