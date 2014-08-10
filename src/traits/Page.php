<?php

namespace nexxes\widgets\traits;

trait Page {
	/**
	 * @var array<\nexxes\widgets\interfaces\StyleSheet>
	 */
	private $_trait_Page_styles = [];
	
	/**
	 * @implements \nexxes\widgets\interfaces\Page
	 */
	public function addStyleSheet(\nexxes\widgets\interfaces\StyleSheet $style) {
		$this->_trait_Page_styles[] = $style;
		return $this;
	}
	
	/**
	 * @implements \nexxes\widgets\interfaces\Page
	 */
	public function getStyleSheets() {
		return $this->_trait_Page_styles;
	}
	
	
	
	
	/**
	 * @var array<\nexxes\widgets\interfaces\Script>
	 */
	private $_trait_Page_scripts = [];
	
	/**
	 * @implements \nexxes\widgets\interfaces\Page
	 */
	public function addScript(\nexxes\widgets\interfaces\Script $script) {
		$this->_trait_Page_scripts[] = $script;
		return $this;
	}
	
	/**
	 * @implements \nexxes\widgets\interfaces\Page
	 */
	public function getScripts() {
		return $this->_trait_Page_scripts;
	}
	
	
	
	
	/**
	 * @var string
	 */
	private $_trait_Page_title;
	
	/**
	 * @implements \nexxes\widgets\interfaces\Page
	 */
	public function getTitle() {
		return $this->_trait_Page_title;
	}
	
	/**
	 * @implements \nexxes\widgets\interfaces\Page
	 */
	public function setTitle($newTitle) {
		$this->_trait_Page_title = $newTitle;
		return $this;
	}
	
	
	
	
	/**
	 * @var \nexxes\widgets\WidgetRegistry
	 */
	private $_trait_Page_widgetRegistry;
	
	/**
	 * Silently initializes the widgets registry with the provided default implementation on first access
	 * @implements \nexxes\widgets\interfaces\Page
	 */
	public function getWidgetRegistry() {
		if (is_null($this->_trait_Page_widgetRegistry)) {
			$this->initWidgetRegistry();
		}
		
		return $this->_trait_Page_widgetRegistry;
	}
	
	/**
	 * @implements \nexxes\widgets\interfaces\Page
	 */
	public function initWidgetRegistry(\nexxes\widgets\WidgetRegistry $newWidgetRegistry = null) {
		if (!is_null($this->_trait_Page_widgetRegistry)) {
			throw new \RuntimeException("Can not replace existing widget registry!");
		}
		
		if (is_null($newWidgetRegistry)) {
			$this->_trait_Page_widgetRegistry = new \nexxes\widgets\WidgetRegistry();
		} else {
			$this->_trait_Page_widgetRegistry = $newWidgetRegistry;
		}
		
		return $this;
	}
}
