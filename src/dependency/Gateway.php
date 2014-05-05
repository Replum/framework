<?php

namespace nexxes\dependency;

/**
 * Static available gateway to the dependency registry
 */
abstract class Gateway {
	/**
	 * The dependency registry handling the actual dependency management
	 * @var \nexxes\dependency\Registry
	 */
	private static $registry = null;
	
	/**
	 * @return \nexxes\dependency\Registry
	 */
	private static function getRegistry() {
		if (is_null(self::$registry)) {
			self::$registry = new Registry();
		}
		
		return self::$registry;
	}
	
	/**
	 * Register an object fulfilling the supplied dependency
	 * 
	 * @param string $dependency Name of the dependency
	 * @param object $fulfillingObject Object that satisfies the dependency
	 */
	public static function registerObject($dependency, $fulfillingObject) {
		return self::getRegistry()->registerObject($dependency, $fulfillingObject);
	}
	
	/**
	 * Register a method that is able to construct an object that fulfills the dependency
	 * 
	 * @param string $dependency Name of the dependency
	 * @param callable $creator Method to create the object
	 */
	public static function registerCreator($dependency, callable $creator) {
		return self::getRegistry()->registerCreator($dependency, $creator);
	}
	
	/**
	 * Get an object fulfilling the supplied dependency
	 * 
	 * @param string $dependency Name of the dependency
	 * @return Object
	 */
	public static function get($dependency) {
		return self::getRegistry()->get($dependency);
	}
}
