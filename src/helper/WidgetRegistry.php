<?php

namespace nexxes\helper;

use \nexxes\iWidget;
use \nexxes\iPage;
use \nexxes\PageContext;

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
	 * @var \nexxes\iPage
	 */
	public $page;
	
	/**
	 * A list of all registered widgets
	 * 
	 * @var array<iWidget>
	 */
	protected $widgets = [];
	
	/**
	 * Containers the id of the parent widget for each widget
	 * @var array<string>
	 */
	protected $parents = [];
	
	/**
	 * The number of seconds to keep data stored
	 * 
	 * @var int
	 */
	protected $ttl = 3600;
	
	/**
	 * Mark initialized widgets to prevent double initialization
	 * 
	 * @var array<bool>
	 */
	protected $inizialized = [];
	
	
	
	
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
	 * Call the initWidget function of all unserialized widgets
	 */
	public function initWidgets() {
		foreach ($this->widgets as $widget) {
			if ($widget instanceof iWidget) {
				$this->initWidget($widget);
			}
		}
	}
	
	
	/**
	 * Generate a unique identifier to use in a widget and register the widget
	 * 
	 * @return string
	 */
	public function register(iWidget $widget, $length = 5) {
		$str = 'w_' . $this->createRandomString($length);
		
		// If new ID is not unique, create a new one that is one char longer
		if (isset($this->widgets[$str])) {
			return $this->register($widget, $length + 1);
		}
		
		$this->widgets[$str] = $widget;
		return $str;
	}
	
	
	/**
	 * Get a widget from the registry or load it from apc cache if not already loaded
	 * 
	 * @param string $id
	 * @return \nexxes\iWidget
	 */
	public function getWidget($id) {
		if (!isset($this->widgets[$id])) {
			throw new \InvalidArgumentException('Unknown widget "' . $id . '" for page "' . $this->pageID . '"');
		}
		
		if (!($this->widgets[$id] instanceof iWidget)) {
			$serialized = \gzinflate($this->widgets[$id]);
			
			if ((false === $serialized) || (false === ($this->widgets[$id] = \unserialize($serialized)))) {
				throw new \RuntimeException('Unable to restore widget "' . $id . '" for page "' . $this->pageID . '"');
			}
			
			$this->initWidgets($this->widgets[$id]);
		}
		
		return $this->widgets[$id];
	}
	
	/**
	 * Restore non-persistable data for the widget
	 * This may happen during page-deserialization, so page does not yet exist
	 * 
	 * @param \nexxes\iWidget $widget
	 */
	protected function initWidget(iWidget $widget) {
		if (isset($this->inizialized[$widget->id]) && $this->inizialized[$widget->id]) {
			return;
		}
		
		if (PageContext::$page instanceof iPage) {
			PageContext::$page->initWidget($widget);
			$this->inizialized[$widget->id] = true;
		}
	}
	
	/**
	 * Get the parent widget for a widget.
	 * If no parent exists, the parent is the page
	 * 
	 * @param \nexxes\iWidget $widget
	 * @return \nexxes\iWidget
	 */
	public function getParent(iWidget $widget) {
		if ($widget instanceof iPage) {
			return null;
		}
		
		elseif (isset($this->parents[$widget->id])) {
			return $this->getWidget($this->parents[$widget->id]);
		}
		
		else {
			return PageContext::$page;
		}
	}
	
	
	/**
	 * Register the parent for a widget
	 * 
	 * @param \nexxes\iWidget $widget
	 * @param \nexxes\iWidget $parent
	 */
	public function setParent(iWidget $widget, iWidget $parent) {
		if (!($parent instanceof iPage)) {
			$this->parents[$widget->id] = $parent->id;
		}
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
	public function persist() {
		// FIXME: special handling for datasources, fix DoctrineDatasource
		if (isset($this->page->table)) {
			$this->page->table->setDataSource();
		}
		\apc_store($this->pageID, \serialize($this));
	}
	
	public static function restore($pid) {
		$serialized = \apc_fetch($pid);
		if ($serialized === false) {
			throw new \RuntimeException('Can not restore page with id "' . $pid . '"');
		}
		
		PageContext::$widgetRegistry = \unserialize(\apc_fetch($pid));
		PageContext::$widgetRegistry->inizialized = [];
		PageContext::$page = PageContext::$widgetRegistry->page;
		
		foreach (PageContext::$widgetRegistry->widgets AS $widget) {
			$widget->updateValues();
		}
		
		PageContext::$widgetRegistry->initWidgets();
	}
}
