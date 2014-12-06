<?php

namespace nexxes\widgets;

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
	
	public function __wakeup() {
	}
	
	public $remoteActions = [];
	
	public function executeRemote($action, $parameters = []) {
		$this->remoteActions[] = [$action, $parameters];
	}
}
