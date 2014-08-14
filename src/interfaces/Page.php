<?php

namespace nexxes\widgets\interfaces;

/**
 * A page represents the main entity to visualize
 */
interface Page extends WidgetContainer {
	/**
	 * Get the widget registry associated with this page
	 * @return \nexxes\widgets\WidgetRegistry
	 */
	function getWidgetRegistry();
	
	/**
	 * Initialize the widget registry so it can be used
	 * @param \nexxes\widgets\WidgetRegistry $newWidgetRegistry
	 * @return \nexxes\widgets\interfaces\Page $this for chaining
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
	 * @return \nexxes\widgets\interfaces\Page $this for chaining
	 */
	function initParameterRegistry(\nexxes\widgets\ParameterRegistry $newParameterRegistry = null);
	
	/**
	 * Get the document title
	 * @return string
	 */
	function getTitle();
	
	/**
	 * Set the document title
	 * @param string $newTitle
	 * @return \nexxes\widgets\interfaces\Page $this for chaining
	 */
	function setTitle($newTitle);
	
	/**
	 * Add a style sheet to the document
	 * @param \nexxes\widgets\interfaces\StyleSheet $style
	 * @return \nexxes\widgets\interfaces\Page $this for chaining
	 */
	function addStyleSheet(StyleSheet $style);
	
	/**
	 * @return array<\nexxes\widgets\interfaces\StyleSheet>
	 */
	function getStyleSheets();
	
	/**
	 * Add a script to the document
	 * @param \nexxes\widgets\interfaces\Script $script
	 * @return \nexxes\widgets\interfaces\Page $this for chaining
	 */
	function addScript(Script $script);
	
	/**
	 * @return array<\nexxes\widgets\interfaces\Script>
	 */
	function getScripts();
	
	/**
	 * Escape the supplied string according to the current HTML escaping rules
	 * 
	 * @param string $unquoted
	 * @return string
	 */
	function escape($unquoted);
}
