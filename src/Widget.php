<?php

namespace nexxes\widgets;

/**
 * Base class that can be used for all widgets
 */
abstract class Widget implements WidgetInterface {
	use WidgetTrait;
	
	//use property\ChangeMonitoringTrait;
	//use property\UpdateValuesTrait;
	
	/**
	 * Unique identifier for the widget within the page
	 * 
	 * @var string
	 */
	public $id;
	
	/**
	 * WAI-ARIA (Web Accessibility Initiative - Accessible Rich Internet Applications) role of the element in the page
	 * 
	 * @var string
	 * @Config(type="string")
	 */
	public $role;
	
	/**
	 * The html classes of this element for styling and JavaScript selection
	 * 
	 * @var array<string>
	 * @Config(type="string", array=true)
	 */
	public $classes = [];
	
	/**
	 * Key to focus this element on the page
	 * 
	 * @var string
	 * @Config(type="string")
	 */
	public $accesskey;
	
	/**
	 * Description/information about an element
	 * 
	 * @var string
	 * @Config(type="string")
	 */
	public $title;
	
	/**
	 * Define order to switch between elements on a page
	 * 
	 * @var int
	 * @Config(type="int")
	 */
	public $tabindex;
	
	/**
	 * Visibility of the element
	 * 
	 * @var bool
	 * @Config(type="bool")
	 */
	public $hidden;
	
	/**
	 * Set focus to this element on page load, may only work on form elements
	 * 
	 * @var bool
	 * @Config(type="bool")
	 */
	public $autofocus;
	
	
	
	
	public function __construct() {
		$this->id = PageContext::$widgetRegistry->register($this);
		//$this->_initializeChangeMonitoring();
	}
	
	
	/**
	 * Called to initialize the object.
	 * Overwrite this model in derived widgets instead of overwriting the constructor
	 */
	public function initialize() {
	}
	
	######################################################################
	# Implementation iWidget
	######################################################################
	
	/**
	 * @implements \nexxes\iWidget
	 */
	public function set($property, $raw) {
		$properties = PageContext::$propertyHandler->getProperties($this);
		$value = $this->sanitizeValue($properties[$property], $raw);
		
		if ($properties[$property]->array && !is_array($value)) {
			$p = $this->$property;
			$p[] = $value;
		} else {
			$this->$property = $value;
		}
		return $this;
	}
	
	
	/**
	 * @implements \nexxes\iWidget
	 */
	public function add($property, $value) {
		return $this->set($property, $value);
	}
	
	/**
	 * @implements \nexxes\iWidget
	 */
	public function del($property, $value) {
		return $this;
	}
	
	/**
	 * Render the HTML representation of the widget and return it as a string
	 * 
	 * @return string The HTML code of the widget
	 */
	public function renderHTML() {
		return $this->renderDefaultHTML();
	}
	
	/**
	 * Try to find a template and render it
	 * @return string
	 */
	protected function renderDefaultHTML() {
		$ro = new \ReflectionObject($this);
		$filename = $ro->getFileName();
		
		if ((!$filename) || (\substr($filename, -4) != '.php')) {
			return '';
		}
		
		$template = \substr($filename, 0, -4) . '.tpl';
		if (!\file_exists($template)) {
			return '';
		}
		
		return $this->smarty()->fetch($template);
	}
	
	######################################################################
	# END Implementation iWidget
	######################################################################
	
	/**
	 * Add a class to the current list of clases
	 * 
	 * @param string $name
	 */
	public function addClass($name) {
		if (!\in_array($name, $this->classes)) {
			$this->classes[] = $name;
		}
		return $this;
	}
	
	/**
	 * Remove a class from the list of classes
	 * 
	 * @param type $name
	 */
	public function delClass($name) {
		$key = \array_search($name, $this->classes);
		
		if ($key !== false) {
			unset($this->classes[$key]);
		}
		
		return $this;
	}
	
	/**
	 * Return a clean smarty instance
	 * 
	 * @return \Smarty
	 */
	protected function smarty() {
		$smarty = clone \nexxes\dependency\Gateway::get(\Smarty::class);
		$smarty->assign('id', $this->id);
		$smarty->assign('widget', $this);
		
		return $smarty;
	}
	
	/*public function serialize() {
		return $this->_SerializeChangeMonitor();
	}
	
	public function unserialize($serialized) {
		$this->_UnserializeChangeMonitor($serialized);
		$this->updateValues();
	}*/
	
	/**
	 * Helper function to generate an attribute list from the default attributes available
	 */
	public function renderCommonAttributes() {
		return ''
			// Common textual values
			. ($this->id    ? ' id="' . $this->escape($this->id) . '"' : '')
			. ($this->title ? ' title="' . $this->escape($this->title) . '"' : '')
			. ($this->accesskey ? ' accesskey="' . $this->escape($this->accesskey) . '"' : '')
			. ($this->role ? ' role="' . $this->escape($this->role) . '"' : '')
			. ($this->tabindex ? ' tabindex="' . $this->escape($this->tabindex) . '"' : '')
			
			// Boolean setting
			. ($this->autofocus ? ' autofocus="autofocus"' : '')
			. ($this->hidden ? ' hidden' : '')
			
			// List types
			. ($this->classes && \count($this->classes) ? ' class="' . \implode(' ', \array_map([$this, 'escape'], $this->classes)) . '"' : '')
		;
	}
	
	/**
	 * Quote all potential harmfull characters in the string
	 * 
	 * @param string $string
	 * @return string
	 */
	protected function escape($string) {
		return \htmlentities($string, null, 'UTF-8');
	}
}
