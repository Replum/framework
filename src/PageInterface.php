<?php

namespace nexxes\widgets;

/**
 * A page represents the main entity to visualize
 */
interface PageInterface extends WidgetContainerInterface {
	/**
	 * Get the widget registry associated with this page
	 * @return \nexxes\widgets\WidgetRegistry
	 */
	function getWidgetRegistry();
	
	/**
	 * Initialize the widget registry so it can be used
	 * @param \nexxes\widgets\WidgetRegistry $newWidgetRegistry
	 * @return \nexxes\widgets\PageInterface $this for chaining
	 */
	function initWidgetRegistry(\nexxes\widgets\WidgetRegistry $newWidgetRegistry = null);
	
	/**
	 * Get the parameter registry that holds all callbacks to fill widget properties from request variables
	 * @return \nexxes\widgets\ParameterRegistry
	 */
	function getParameterRegistry();
	
	/**
	 * Initialize the parameter registry with the supplied parameter registry object or create a new object
	 * @param \nexxes\widgets\ParameterRegistry $newParameterRegistry
	 * @return \nexxes\widgets\PageInterface $this for chaining
	 */
	function initParameterRegistry(\nexxes\widgets\ParameterRegistry $newParameterRegistry = null);
	
	/**
	 * Get the event dispatcher that handles ajax events
	 * @return \nexxes\widgets\events\WidgetEventDispatcher
	 */
	function getEventDispatcher();
	
	/**
	 * Initialize the event dispatcher with the supplied event dispatcher object or create a new object
	 * @param \nexxes\widgets\events\WidgetEventDispatcher $eventDispatcher
	 * @return \nexxes\widgets\PageInterface $this for chaining
	 */
	function initEventDispatcher(\nexxes\widgets\events\WidgetEventDispatcher $eventDispatcher = null);
	
	/**
	 * Get the document title
	 * @return string
	 */
	function getTitle();
	
	/**
	 * Set the document title
	 * @param string $newTitle
	 * @return \nexxes\widgets\PageInterface $this for chaining
	 */
	function setTitle($newTitle);
	
	/**
	 * Add a style sheet to the document
	 * @param \nexxes\widgets\StyleSheetInterface $style
	 * @return \nexxes\widgets\PageInterface $this for chaining
	 */
	function addStyleSheet(StyleSheetInterface $style);
	
	/**
	 * @return array<\nexxes\widgets\StyleSheetInterface>
	 */
	function getStyleSheets();
	
	/**
	 * Add a script to the document
	 * @param \nexxes\widgets\ScriptInterface $script
	 * @return \nexxes\widgets\PageInterface $this for chaining
	 */
	function addScript(ScriptInterface $script);
	
	/**
	 * @return array<\nexxes\widgets\ScriptInterface>
	 */
	function getScripts();
	
	/**
	 * Escape the supplied string according to the current HTML escaping rules
	 * 
	 * @param string The raw string
	 * @return string
	 */
	function escape($unquoted);
}
