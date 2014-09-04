<?php

namespace nexxes\widgets\pagedef;

use \nexxes\widgets\WidgetInterface;

/**
 * @author Dennis Birkholz <dennis.birkholz@nexxes.net>
 */
class XMLImporter extends StructImporter {
	/**
	 * The resolver to find fully qualified class names
	 * @var callable
	 */
	private $resolver;
	
	
	
	public function __construct(callable $resolver = null) {
		if ($resolver !== null) {
			$this->resolver = $resolver;
		} else {
			$this->resolver = [$this, 'defaultResolver'];
		}
	}
	
	/**
	 * {@inheritdoc}
	 */
	public function importFile(WidgetInterface $root, $filename) {
		if (!\file_exists($filename) || !\is_readable($filename)) {
			throw new \RuntimeException('Can not open widget structure file "' . $filename . '"');
		}
		
		$data = \file_get_contents($filename);
		return $this->import($root, $data);
	}
	
	/**
	 * {@inheritdoc}
	 */
	public function import(WidgetInterface $root, $xmlstring) {
		$dom = new \DOMDocument();
		$dom->loadXML($xmlstring);
		
		// FIXME: better error handling
		if (!$dom->hasChildNodes()) {
			throw new \RuntimeException('Invalid document structure, empty root element');
		}
		
		$struct = $this->recurse(new structure\Widget(\get_class($root)), $dom->childNodes->item(0));
		return parent::import($root, $struct);
	}
	
	/**
	 * Parse XML subtree in $node into the supplied $widget.
	 * 
	 * @param \nexxes\widgets\pagedef\structure\Widget $widget
	 * @param \DOMNode $node
	 * @return \nexxes\widgets\pagedef\structure\Widget
	 */
	private function recurse(structure\Widget $widget, \DOMNode $node) {
		if ($node->hasAttributes()) {
			// Class to use for child widget
			if ($node->attributes->getNamedItem('class') !== null) {
				$widget->class = \call_user_func($this->resolver, $node->attributes->getNamedItem('class')->value);
			}
			
			// Create reference in root linking to current widget
			if ($node->attributes->getNamedItem('ref') !== null) {
				$widget->ref = $node->attributes->getNamedItem('ref')->value;
			}
		}
		
		// Use XML tag as class name
		if ($widget->class === null) {
			$widget->class = \call_user_func($this->resolver, $node->nodeName);
		}
		
		foreach ($node->childNodes AS $childNode) {
			// Skip whitespace
			if (($childNode instanceof \DOMText) && ($childNode->isWhitespaceInElementContent())) { continue; }
			
			/* @var $childNode \DOMNode */
			$childName = $childNode->nodeName;
			
			// Property handling
			if ($childName === 'property') {
				// FIXME
				$widget->properties[] = $this->parseProperty($childNode);
			}
			
			// Child nodes
			else {
				// Check for slot
				if (isset($childNode->attributes) && ($childNode->attributes->getNamedItem('slot') !== null)) {
					$slotname = $childNode->attributes->getNamedItem('slot')->value;
					if (\substr($slotname, -2) === '[]') {
						$slotname = \substr($slotname, 0, \strlen($slotname)-2);
						$append = true;
					} else {
						$append = false;
					}
					
					$childWidget = new structure\Slot(null, $slotname, $append);
				}
				
				// Simple child
				else {
					$childWidget = new structure\Child(null);
				}
				
				$widget->add($this->recurse($childWidget, $childNode));
			}
		}
		
		return $widget;
	}
	
	/**
	 * Parse a <property> node and return [ $propertyName => $propertyValue ]
	 * 
	 * @param \DOMNode $node
	 */
	private function parseProperty(\DOMNode $node) {
		if ($node->nodeName !== 'property') {
			throw new \InvalidArgumentException('Non-property node should never have been suplied to ' . __METHOD__);
		}
		
		if (!$node->hasAttributes()) {
			throw new \UnexpectedValueException('No attributes available but "name" attribute required for "property" tag in line ' . $node->getLineNo());
		}

		// Require property tag to have a "name" attribute
		if ($node->attributes->getNamedItem('name') === null) {
			throw new \UnexpectedValueException('Missing "name" attribute of "property" tag in line ' . $node->getLineNo());
		} else {
			$attrName = $node->attributes->getNamedItem('name')->value;
		}

		// The property is set in the form <property name="propName" value="propValue" />
		if ($node->attributes->getNamedItem('value') !== null) {
			$attrValue = $node->attributes->getNamedItem('value')->value;
		}

		// The property is set in the form <property name="propName">propValue</property>
		elseif (($node->childNodes !== null) && ($node->childNodes->length === 1) && ($node->childNodes->item(0) instanceof \DOMText)) {
			$attrValue = $node->childNodes->item(0)->wholeText;
		}

		// Property is a widget definition
		else {
			foreach ($node->childNodes AS $propertyChildNode) {
				if ($propertyChildNode instanceof \DOMText) {
					if ($propertyChildNode->isWhitespaceInElementContent()) { continue; }
					else { throw new \UnexpectedValueException('Property should not contain both text and widgets block in line ' . $propertyChildNode->getLineNo()); }
				}

				if (isset($attrValue)) {
					throw new \UnexpectedValueException('Can only assign a single widget to a property in line ' . $propertyChildNode->getLineNo());
				}

				$attrValue = $this->recurse(new structure\Widget(null), $propertyChildNode);
			}
		}

		if (!isset($attrValue)) {
			throw new \UnexpectedValueException('No property value set in line ' . $node->getLineNo());
		}
		
		return new structure\Property($attrName, $attrValue);
	}
	
	/**
	 * The default resolver just returns the classname unchanged, supply a custom resolver if required
	 * 
	 * @param string $classname
	 * @return string
	 */
	private function defaultResolver($classname) {
		return $classname;
	}
}
