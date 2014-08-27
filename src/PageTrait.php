<?php

namespace nexxes\widgets;

use \Symfony\Component\EventDispatcher\EventDispatcherInterface;
use \Symfony\Component\EventDispatcher\EventDispatcher;

trait PageTrait {
	/**
	 * @var array<\nexxes\widgets\StyleSheetInterface>
	 */
	private $PageTraitStyles = [];
	
	/**
	 * @implements \nexxes\widgets\PageInterface
	 */
	public function addStyleSheet(\nexxes\widgets\StyleSheetInterface $style) {
		$this->PageTraitStyles[] = $style;
		return $this;
	}
	
	/**
	 * @implements \nexxes\widgets\PageInterface
	 */
	public function getStyleSheets() {
		return $this->PageTraitStyles;
	}
	
	
	
	
	/**
	 * @var array<\nexxes\widgets\ScriptInterface>
	 */
	private $PageTraitScripts = [];
	
	/**
	 * @implements \nexxes\widgets\PageInterface
	 */
	public function addScript(\nexxes\widgets\ScriptInterface $script) {
		$this->PageTraitScripts[] = $script;
		return $this;
	}
	
	/**
	 * @implements \nexxes\widgets\PageInterface
	 */
	public function getScripts() {
		return $this->PageTraitScripts;
	}
	
	
	
	
	/**
	 * @var string
	 */
	private $PageTraitTitle;
	
	/**
	 * @implements \nexxes\widgets\PageInterface
	 */
	public function getTitle() {
		return $this->PageTraitTitle;
	}
	
	/**
	 * @implements \nexxes\widgets\PageInterface
	 */
	public function setTitle($newTitle) {
		$this->PageTraitTitle = $newTitle;
		return $this;
	}
	
	
	
	
	/**
	 * @var \nexxes\widgets\WidgetRegistry
	 */
	private $PageTraitWidgetRegistry;
	
	/**
	 * Silently initializes the widget registry with the provided default implementation on first access
	 * @implements \nexxes\widgets\PageInterface
	 */
	public function getWidgetRegistry() {
		if (is_null($this->PageTraitWidgetRegistry)) {
			$this->initWidgetRegistry();
		}
		
		return $this->PageTraitWidgetRegistry;
	}
	
	/**
	 * @implements \nexxes\widgets\PageInterface
	 */
	public function initWidgetRegistry(\nexxes\widgets\WidgetRegistry $newWidgetRegistry = null) {
		if (!is_null($this->PageTraitWidgetRegistry)) {
			throw new \RuntimeException("Can not replace existing widget registry!");
		}
		
		if (is_null($newWidgetRegistry)) {
			$this->PageTraitWidgetRegistry = new \nexxes\widgets\WidgetRegistry();
		} else {
			$this->PageTraitWidgetRegistry = $newWidgetRegistry;
		}
		
		return $this;
	}
	
	
	
	
	/**
	 * @var \nexxes\widgets\ParameterRegistry
	 */
	private $PageTraitParameterRegistry;
	
	/**
	 * Silently initializes the parameter registry with the provided default implementation on first access
	 * @implements \nexxes\widgets\PageInterface
	 */
	public function getParameterRegistry() {
		if (is_null($this->PageTraitParameterRegistry)) {
			$this->initParameterRegistry();
		}
		
		return $this->PageTraitParameterRegistry;
	}
	
	/**
	 * @implements \nexxes\widgets\PageInterface
	 */
	public function initParameterRegistry(\nexxes\widgets\ParameterRegistry $newParameterRegistry = null) {
		if (!is_null($this->PageTraitParameterRegistry)) {
			throw new \RuntimeException("Can not replace existing parameter registry!");
		}
		
		if (is_null($newParameterRegistry)) {
			$this->PageTraitParameterRegistry = new \nexxes\widgets\ParameterRegistry();
		} else {
			$this->PageTraitParameterRegistry = $newParameterRegistry;
		}
		
		return $this;
	}
	
	
	
	
	/**
	 * @var \Symfony\Component\EventDispatcher\EventDispatcherInterface
	 */
	private $PageTraitEventDispatcher;
	
	/**
	 * Silently initializes the event dispatcher with a default implementation on first access
	 * @implements \nexxes\widgets\PageInterface
	 */
	public function getEventDispatcher() {
		if (is_null($this->PageTraitEventDispatcher)) {
			$this->initEventDispatcher();
		}
		
		return $this->PageTraitEventDispatcher;
	}
	
	/**
	 * @implements \nexxes\widgets\PageInterface
	 */
	public function initEventDispatcher(EventDispatcherInterface $newEventDispatcher = null) {
		if (!is_null($this->PageTraitEventDispatcher)) {
			throw new \RuntimeException("Can not replace existing event dispatcher!");
		}
		
		if (is_null($newEventDispatcher)) {
			$this->PageTraitEventDispatcher = new EventDispatcher();
		} else {
			$this->PageTraitEventDispatcher = $newEventDispatcher;
		}
		
		return $this;
	}
}
