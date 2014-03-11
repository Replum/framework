<?php

namespace nexxes\dependency;

/**
 * 
 */
class Injector {
	/**
	 * Contains the dependencies injectable
	 * Each possible dependency is identified by an interface name which is the key of the array.
	 * The value is an array containing:
	 *  - a 'method' element that is called to inject the dependency
	 *  - an 'instance' element that contains the dependency once it has been instantiated
	 *  - a 'creator' element containing a callable that returns the instance
	 * 
	 * @var array
	 */
	private $registry = [];
	
	/**
	 * 
	 * @param string $name Name of the interface used to identify the dependency
	 * @param string $method The method name used to inject the dependency
	 * @param callable $creator Callable that creates a new instance
	 */
	public function register($name, $method, callable $creator) {
		$this->registry[$name] = [
				'method' => $method,
				'creator' => $creator,
				'instance' => null
		];
	}
	
	/**
	 * 
	 */
	public function inject($obj) {
		$interfaces = \class_implements($obj);
		
		foreach ($interfaces AS $interface) {
			if (!isset($this->registry[$interface])) {
				continue;
			}
			
			if (is_null($this->registry[$interface]['instance'])) {
				$this->registry[$interface]['instance'] = $this->registry[$interface]['creator']();
			}
			
			$obj->{$this->registry[$interface]['method']}($this->registry[$interface]['instance']);
		}
	}
}
