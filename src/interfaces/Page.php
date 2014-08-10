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
}
