<?php

namespace nexxes\dependency;

/**
 * Registry that handles the dependency management
 */
class Registry {
	/**
	 * List of creators for delayed dependency creation
	 * @var array<\callable>
	 */
	private $creators = [];
	
	/**
	 * List of instantiated dependency objects
	 * @var array<Object>
	 */
	private $instances = [];
	
	
	
	
	/**
	 * Register an object fulfilling the supplied dependency
	 * 
	 * @param string $dependency Name of the dependency
	 * @param Object $fulfillingObject Object that satisfies the dependency
	 */
	public function registerObject($dependency, $fulfillingObject) {
		$this->instances[$dependency] = $fulfillingObject;
		return true;
	}
	
	/**
	 * Register a method that is able to construct an object that fulfills the dependency
	 * 
	 * @param string $dependency Name of the dependency
	 * @param callable $creator Method to create the object
	 */
	public function registerCreator($dependency, callable $creator) {
		$this->creators[$dependency] = $creator;
		return true;
	}
	
	/**
	 * Get an object fulfilling the supplied dependency
	 * 
	 * @param string $dependency Name of the dependency
	 * @return Object
	 */
	public function get($dependency) {
		if (!isset($this->instances[$dependency])) {
			if (!isset($this->creators[$dependency])) {
				throw new \RuntimeException('Dependency error for dependency "' . $dependency .'": no dependency and no creator registered.');
			}
			
			$fulfillingObject = $this->creators[$dependency]();
			if (is_null($fulfillingObject) || ($fulfillingObject === false)) {
				throw new \RuntimeException('Dependency error for dependency "' . $dependency .'": creator failed to instantiate new object.');
			}
			
			$this->instances[$dependency] = $fulfillingObject;
		}
		
		return $this->instances[$dependency];
	}
}
