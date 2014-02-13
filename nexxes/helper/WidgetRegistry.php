<?php

namespace nexxes\helper;

use \nexxes\iWidget;

/**
 * 
 */
class WidgetRegistry {
	/**
	 * The cache global page identifier
	 * 
	 * @var string
	 */
	public $pageID;
	
	/**
	 * A list of all registered widgets
	 * 
	 * @var array<iWidget>
	 */
	private $widgets = [];
	
	/**
	 * The number of seconds to keep data stored
	 * 
	 * @var int
	 */
	private $ttl = 3600;
	
	
	
	
	/**
	 * Create a unique page id
	 */
	public function __construct() {
		$length = 8;
		
		// Create a cache global unique page identifier
		do {
			$this->pageID = 'p_' . $this->createRandomString($length++);
		} while (\apc_add($this->pageID, true) === false);
	}
	
	
	/**
	 * Generate a unique identifier to use in a widget and register the widget
	 * 
	 * @return string
	 */
	public function registerWidget(iWidget $widget, $length = 5) {
		$str = 'w_' . $this->createRandomString($length);
		
		// If new ID is not unique, create a new one that is one char longer
		if (isset($this->widgets[$str])) {
			return $this->registerWidget($widget, $length + 1);
		}
		
		$this->widgets[$str] = $widget;
		return $str;
	}
	
	
	/**
	 * Get a widget from the registry or load it from apc cache if not already loaded
	 * 
	 * @param string $id
	 * @return iWidget
	 */
	public function getWidget($id) {
		if (!isset($this->widgets[$id])) {
			throw new \InvalidArgumentException('Unknown widget "' . $id . '" for page "' . $this->pageID . '"');
		}
		
		if (!($this->widgets[$id] instanceof iWidget)) {
			$serialized = \apc_fetch($this->pageID . '-' . $id);
			
			if ((false === $serialized) || (false === ($this->widgets[$id] = \unserialize($serialized)))) {
				throw new \RuntimeException('Unable to restore widget "' . $id . '" for page "' . $this->pageID . '"');
			}
		}
		
		return $this->widgets[$id];
	}
	
	
	/**
	 * Create a random string from the supplied character pool with the supplied number of chars
	 * 
	 * @param int $length
	 * @param array<char> $chars
	 * @return string
	 */
	private function createRandomString($length = 8, $chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ') {
		$str = '';
		
		for ($i=0; $i<$length; $i++) {
			$str .= $chars[rand(0, \strlen($chars)-1)];
		}
		
		return $str;
	}
	
	/**
	 * Method called when widget registry is persisted.
	 * Stores all widgets separately in the apc cache
	 */
	public function __sleep() {
		foreach ($this->widgets AS $id => $widget) {
			// Persisted widget that was not restored
			if (!($widget instanceof iWidget)) { continue; }
			
			$serialized = \serialize($widget);
			apc_store($this->pageID . '-' . $id, $serialized);
			$this->widgets[$id] = true;
		}
		
		return ['pageID', 'widgets'];
	}
}
