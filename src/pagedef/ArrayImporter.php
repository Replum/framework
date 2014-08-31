<?php

namespace nexxes\widgets\pagedef;

use \nexxes\widgets\PageInterface;
use \nexxes\widgets\WidgetContainerInterface;
use \nexxes\widgets\WidgetCompositeInterface;

/**
 * The PageInitializer creates the widget structure specified for a page.
 * 
 * The structure required to initialize is like the following:
 * 
 * <code>
 * $pageStructureDefinition = [
 * 
 * ];
 * </code>
 *
 * @author Dennis Birkholz <dennis.birkholz@nexxes.net>
 */
class ArrayImporter implements ImporterInterface {
	/**
	 * List of namespaces to search in for Widget class creation
	 * @var array<string>
	 */
	private $namespaces = [];
	
	/**
	 * @param array<string> $namespaces
	 */
	public function __construct($namespaces = []) {
		$this->namespaces = $namespaces;
	}
	
	public function importFile(PageInterface $page, $filename) {
		if (!\file_exists($filename) || !\is_readable($filename)) {
			throw new \RuntimeException('Can not open page structure file "' . $filename . '"');
		}
		
		$data = \file_get_contents($filename);
		return $this->import($page, $data);
	}
	
	public function import(PageInterface $page, $data) {
		$data['class'] = \get_class($page);
		
		return 'return function(' . PageInterface::class . ' $page) {' . PHP_EOL
			. $this->generateWidgetInitialization([], 'page', $data) . PHP_EOL
			. '};' . PHP_EOL;
	}
	
	public function generateWidgetInitialization(array $prefix, $name, array $widgetStructure) {
		// The return value
		$r = '';
		
		// Step in
		$newPrefix = array_merge($prefix, [$name]);
		
		// Variable for the current element
		$currentVar = '$' . \implode('_', $newPrefix);
		
		// Variable for the parent element
		$parentVar = '$' . \implode('_', $prefix);
		
		// Structure requires class definition
		if (!isset($widgetStructure['class'])) {
			throw new \UnexpectedValueException('Each structure element requires a class!');
		}
		
		// If class indicates a Page, the page is already created
		if (is_a($widgetStructure['class'], PageInterface::class, true)) {
			$class = $widgetStructure['class'];
		}
		
		// Non-page widgets must be created first
		else {
			$class = $this->resolveClass($widgetStructure['class']);
			
			if (isset($widgetStructure['name'])) {
				$r .= '$page->' . $widgetStructure['name'] . ' = ';
			}
			
			$r .= $currentVar . ' = new ' . $class . '(' . $parentVar . ');' . PHP_EOL;
		}
		
		// Set all properties
		// FIXME: implement widget property handling
		if (isset($widgetStructure['properties'])) {
			$r .= $currentVar;
			
			foreach ($widgetStructure['properties'] AS $propertyName => $propertyValue) {
				// Try to find the setter method:
				// - try addVar for list types (like css classes)
				// - try setVar for "simple" properties
				// - throw error
				if (\method_exists($class, 'add' . \ucfirst($propertyName))) {
					$setter = 'add' . \ucfirst($propertyName);
				} elseif (\method_exists($class, 'set' . \ucfirst($propertyName))) {
					$setter = 'set' . \ucfirst($propertyName);
				} else {
					throw new \InvalidArgumentException('No accessible setter for property "' . $propertyName . '" found.');
				}
				
				$r .= PHP_EOL . "\t" . '->' . $setter . '(' . \var_export($propertyValue, true) . ')';
			}
			
			$r .= PHP_EOL . ';' . PHP_EOL . PHP_EOL;
		}
		
		// Add children
		if (isset($widgetStructure['children'])) {
			if (!is_a($class, WidgetContainerInterface::class, true)) {
				throw new \UnexpectedValueException('Class "' . $class . '" can not have children, must implement "' . WidgetContainerInterface::class . '" (' . \implode('->', $newPrefix) . ')');
			}
			
			foreach ($widgetStructure['children'] AS $childCounter => $childStructure) {
				$r .= $currentVar . '[] = ' . $this->generateWidgetInitialization($newPrefix, 'child' . $childCounter, $childStructure) . PHP_EOL;
			}
		}
		
		// Fill slots
		if (isset($widgetStructure['slots'])) {
			if (!is_a($class, WidgetCompositeInterface::class, true)) {
				throw new \UnexpectedValueException('Class "' . $class . '" can not have slots, must implement "' . WidgetCompositeInterface::class . '" (' . \implode('->', $newPrefix) . ')');
			}
			
			foreach ($widgetStructure['slots'] AS $slotName => $slotStructure) {
				$r .= $currentVar . '[' . \var_export($slotName, true) . '] = ' . $this->generateWidgetInitialization($newPrefix, $slotName, $slotStructure) . PHP_EOL;
			}
		}
		
		return $r;
	}
	
	protected function resolveClass($className) {
		if (\class_exists($className)) {
			return $className;
		}
		
		foreach ($this->namespaces AS $ns) {
			$qualified = $ns . '\\' . $className;
			
			if (\class_exists($qualified)) {
				return $qualified;
			}
		}
		
		throw new \RuntimeException('Can not resolve class "' . $className . '"');
	}
}
