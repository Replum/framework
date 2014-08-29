<?php

namespace nexxes\widgets;

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
class PageInitializer {
	public $namespaces = [
		'\nexxes\widgets\bootstrap',
		'\nexxes\widgets\html',
		'\nexxes\widgets',
	];
	
	function blubb() {
		$pageStructureDefinition = [
			// Named properties: (e.g. title, class, id)
			// These properties should not contain other widgets, use slots or children for that
			'properties' => [
				'title' => 'test page title',
			],
			
			// If the page implements WidgetComposite, slots can be used
			'slots' => [
				'slotname' => $widgetStructureDefinition,
			],
			
			'widgets' => [
				$widgetStructureDefinition,
			]
		];
		
		// A widget structure definition is similar to the $pageStructureDefinition
		$widgetStructureDefinition = [
			// the class of the widget to create
			'class' => 'WidgetClass',
			
			// Properties like in $pageStructureDefinition
			'properties' => [
				'propname' => 'propvalue',
			],
			
			// If the widget implements the WidgetCompositeInterface, slots can be used
			'slots' => [
				'slotname' => $widgetStructureDefinition,
			],
			
			// If the widget implements the WidgetContainerInterface, widgets can be created
			'widgets' => [
				$widgetStructureDefinition,
			],
		];
	}
	
	public function run(PageInterface $page, array $pageStructure) {
		$pageStructure['class'] = \get_class($page);
		
		return 'return function(' . PageInterface::class . ' $page) {' . PHP_EOL
			. $this->generateWidgetInitialization([], 'page', $pageStructure) . PHP_EOL
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
				
				$r .= "\t" . '->' . $setter . '(' . \var_export($propertyValue, true) . ')' . PHP_EOL;
			}
			
			$r .= ';' . PHP_EOL;
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
				$r .= $currentVar . '[' . $slotName . '] = ' . $this->generateWidgetInitialization($newPrefix, $slotName, $slotStructure) . PHP_EOL;
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
