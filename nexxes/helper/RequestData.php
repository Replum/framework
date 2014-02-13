<?php

namespace nexxes\helper;

use \nexxes\iWidget;

/**
 * Parses the current request data, provides it to the page and to widgets
 * and creates links to the current page preserving required get variables.
 */
class RequestData {
	/**
	 * Page type to use for current page
	 * 
	 * @var string
	 */
	private $page;
	
	/**
	 * Page identifier if passed
	 * 
	 * @var string
	 */
	private $pid;
	
	/**
	 * All cookie variables, grouped by widget
	 * 
	 * @var array<string>
	 */
	private $cookies = [];
	
	/**
	 * All get variables, grouped by widget
	 * 
	 * @var array<string>
	 */
	private $get = [];
	
	/**
	 * All post variables, grouped by widget
	 * 
	 * @var array<string>
	 */
	private $post = [];
	
	
	
	
	public function __construct() {
		if (isset($_REQUEST['pid'])) {
			$this->pid = $_REQUEST['pid'];
		}
		
		elseif (isset($_REQUEST['page'])) {
			$this->page = $_REQUEST['page'];
		}
		
		$this->cookies = $this->parseArray($_COOKIE);
		$this->get     = $this->parseArray($_GET);
		$this->post    = $this->parseArray($_POST);
	}
	
	
	/**
	 * 
	 */
	public function link($widget, $key, $value = null) {
		$args = \func_get_args();
		$widget = \array_shift($args);
		$id = (($widget instanceof iWidget) ? $widget->id : $widget);
		
		// Build params from GET vars
		$params = [];
		foreach ($this->get AS $widget_id => $widget_data) {
			foreach ($widget_data AS $key => $value) {
				$params[$widget_id . '|' . $key] = $value;
			}
		}
		
		while (\count($args)) {
			$key = $id . '|' . \array_shift($args);
			$value = @\array_shift($args);
			
			// Unset request variable for NULL values
			if (is_null($value)) {
				unset($params[$key]);
			}
			
			// Append array values
			elseif (isset($params[$key]) && is_array($params[$key])) {
				$params[$key][] = $value;
			}
			
			// Set/replace values
			else {
				$params[$key] = $value;
			}
		}
		
		return $_SERVER["PHP_SELF"] . '?' . \http_build_query($params);
	}
	
	
	/**
	 * Get the page ID if it is supplied or FALSE if not set
	 * 
	 * @return string
	 */
	public function getPageID() {
		if (isset($this->pid)) {
			return $this->pid;
		} else {
			return false;
		}
	}
	
	
	/**
	 * Get the page name if it is supplied or FALSE if not set
	 * 
	 * @return string
	 */
	public function getPage() {
		if (isset($this->page)) {
			return $this->page;
		} else {
			return false;
		}
	}
	
	
	/**
	 * Get the page name if it is supplied or FALSE if not set
	 * 
	 * @return string
	 */
	public function get() {
		if (isset($this->page)) {
			return $this->page;
		} else {
			return false;
		}
	}
	
	
	/**
	 * Get a request value for the supplied widget
	 * 
	 * @param iWidget|string $widget
	 * @param string $key
	 * @return mixed
	 */
	public function getValue($widget, $key) {
		$id = (($widget instanceof iWidget) ? $widget->id : $widget);
		
		if (isset($this->cookies[$id][$key])) {
			return $this->cookies[$id][$key];
		}
		elseif (isset($this->post[$id][$key])) {
			return $this->post[$id][$key];
		}
		elseif (isset($this->get[$id][$key])) {
			return $this->get[$id][$key];
		}
	}
	
	
	/**
	 * Get the GET/POST/COOKIE variables for a widget, merged together
	 * 
	 * @param iWidget|string $widget
	 * @return array
	 */
	public function getValues($widget) {
		return \array_merge($this->getGet($widget), $this->getPost($widget), $this->getCookies($widget));
	}
	
	
	/**
	 * Get the COOKIE variables for the supplied widget
	 * 
	 * @param iWidget|string $widget
	 * @return array
	 */
	public function getCookies($widget) {
		return $this->getWidgetData($this->cookies, $widget);
	}
	
	
	/**
	 * Get the GET variables for the supplied widget
	 * 
	 * @param iWidget|string $widget
	 * @return array
	 */
	public function getGet($widget) {
		return $this->getWidgetData($this->get, $widget);
	}
	
	
	/**
	 * Get the POST variables for the supplied widget
	 * 
	 * @param iWidget|string $widget
	 * @return array
	 */
	public function getPost($widget) {
		return $this->getWidgetData($this->post, $widget);
	}
	
	
	/**
	 * Get the variables from the supplied data array for the supplied widget
	 * 
	 * @param array $data
	 * @param iWidget|string $widget
	 * @return array
	 */
	private function getWidgetData(&$data, $widget) {
		$id = (($widget instanceof iWidget) ? $widget->id : $widget);
		
		if (isset($data[$id])) {
			return $data[$id];
		} else {
			return [];
		}
	}
	
	
	/**
	 * Helper function to separate $_GET/$_POST arrays by widget
	 * 
	 * @param array $input
	 * @return array
	 */
	private function parseArray(array $input) {
		$data = [];
		
		foreach ($input AS $key => $value) {
			// Skip vars not prefixed by widget id
			if (\strstr($key, '|') === false) { continue; }
			
			list($widget, $key) = \explode('|', $key);
			
			if (!isset($data[$widget])) {
				$data[$widget] = [];
			}
			
			$data[$widget][$key] = $value;
		}
		
		return $data;
	}
}
