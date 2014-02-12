<?php

namespace nexxes\property;

/**
 * Extracts property config annotations from classes and stores them
 */
class Handler {
	/**
	 * @var array<\nexxes\property\Config>
	 */
	private $properties = [];
	
	/**
	 * @var \Doctrine\Common\Annotations\AnnotationReader
	 */
	private $annotationReader;
	
	public function __construct() {
		// Trigger autoloading
		new Config();
		
		$this->annotationReader = new \Doctrine\Common\Annotations\AnnotationReader();
	}
	
	/**
	 * Get the properties for the supplied object
	 * If no properties for that class have been extracted from annotations, do it
	 * 
	 * @param object $obj
	 * @return array<\nexxes\property\Config>
	 */
	public function getProperties($obj) {
		$class = \get_class($obj);
		
		if (!isset($this->properties[$class])) {
			$this->initializeProperties($class);
		}
		
		return $this->properties[$class];
	}
	
	/**
	 * Initialize the properties for the supplied class
	 * 
	 * @param string $class
	 */
	private function initializeProperties($class) {
		$this->properties[$class] = [];
		
		$reflectionClass = new \ReflectionClass($class);
		
		// Walk all properties of the class and extract annotations
		foreach ($reflectionClass->getProperties(\ReflectionProperty::IS_PUBLIC) AS $property) {
			$config = $this->annotationReader->getPropertyAnnotation($property, 'nexxes\property\Config');
			$config->name = $property->name;
			
			// Skip unconfigured properties
			if (!$config) { continue; }
			
			// Simple type
			if (\in_array($config->type, ['bool', 'int', 'float', 'string'])) {
				$config->scalar = true;
			}
			
			// Type is a class, try to find it
			// FIXME: rudimentary search, if class not found, exception is thrown later
			else {
				$config->scalar = false;
				
				if ($config->type[0] !== '\\') {
					$config->type = '\\' . \substr($class, 0, \strrpos($class, '\\')) . '\\' . $config->type;
				}
			}
			
			// Clean up number specific stuff
			if (!$config->scalar || !in_array($config->type, ['int', 'float'])) {
				unset($config->min);
				unset($config->max);
			}
			
			$this->properties[$class][$property->name] = $config;
		}
	}
}
