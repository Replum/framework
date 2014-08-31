<?php

namespace nexxes\widgets\pagedef;

use \nexxes\widgets\PageInterface;

/**
 * @author Dennis Birkholz <dennis.birkholz@nexxes.net>
 */
class XMLImporter implements ImporterInterface {
	/**
	 * @var \nexxes\widgets\pagedef\ArrayImporter
	 */
	private $arrayImporter;
	
	/**
	 * Initialize the XMLImporter with an ArrayImporter if the ArrayImporter requires special setup like additional namespaces, etc.
	 * 
	 * @param \nexxes\widgets\pagedef\ArrayImporter $arrayImporter
	 */
	public function __construct(ArrayImporter $arrayImporter = null) {
		$this->arrayImporter = ($arrayImporter ?: new ArrayImporter());
	}
	
	public function importFile(PageInterface $page, $filename) {
		if (!\file_exists($filename) || !\is_readable($filename)) {
			throw new \RuntimeException('Can not open page structure file "' . $filename . '"');
		}
		
		$data = \file_get_contents($filename);
		return $this->import($page, $data);
	}
	
	public function import(PageInterface $page, $data) {
		return $this->arrayImporter->import($page, $this->createArrayStructure($data));
	}
	
	/**
	 * @param string $xmlstring
	 */
	public function createArrayStructure($xmlstring) {
		$root = new \DOMDocument();
		$root->loadXML($xmlstring);
		
		if (!$root->hasChildNodes() || ($root->childNodes->item(0)->nodeName !== 'page')) {
			throw new \RuntimeException('Invalid document structure, XML document must be contained within a <page> element.');
		}
		
		return $this->recurse($root->childNodes->item(0));
	}
	
	public function recurse(\DOMNode $node, $depth = 0) {
		$struct = [
			'properties' => [],
			'children' => [],
			'slots' => [],
		];
		
		// Class to use for this widget
		if ($node->hasAttributes() && ($node->attributes->getNamedItem('class') !== null)) {
			$struct['class'] = $node->attributes->getNamedItem('class')->value;
		}
		
		// Attribute of $page to use as a shortcut to this widget
		if ($node->hasAttributes() && ($node->attributes->getNamedItem('name') !== null)) {
			$struct['name'] = $node->attributes->getNamedItem('name')->value;
		}
		
		foreach ($node->childNodes AS $childNode) {
			if (($childNode instanceof \DOMText) && ($childNode->isWhitespaceInElementContent())) { continue; }
			
			/* @var $childNode \DOMNode */
			$childName = $childNode->nodeName;
			
			// Property handling
			if ($childName === 'property') {
				$struct['properties'] = \array_merge($struct['properties'], $this->parseProperty($childNode));
			}
			
			// Child nodes
			elseif ($childNode->hasChildNodes()) {
				$data = $this->recurse($childNode, $depth+1);
				if (!isset($data['class'])) {
					$data['class'] = $childName;
				}
				
				if ($childNode->attributes->getNamedItem('slot')) {
					$struct['slots'][$childNode->attributes->getNamedItem('slot')->value] = $data;
				} else {
					$struct['children'][] = $data;
				}
			}
		}
		
		if (!\count($struct['properties'])) {
			unset($struct['properties']);
		}
		
		if (!\count($struct['children'])) {
			unset($struct['children']);
		}
		
		if ($struct['slots'] === []) {
			unset($struct['slots']);
		}
		
		return $struct;
	}
	
	/**
	 * Parse a <property> node and return [ $propertyName => $propertyValue ]
	 * 
	 * @param \DOMNode $node
	 */
	public function parseProperty(\DOMNode $node) {
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

				$attrValue = $this->recurse($propertyChildNode);
			}
		}

		if (!isset($attrValue)) {
			throw new \UnexpectedValueException('No property value set in line ' . $node->getLineNo());
		}

		return [ $attrName => $attrValue ];
	}
}
