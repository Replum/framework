<?php

namespace nexxes;

/**
 * The pagecontext holds references to all relevant objects
 * like the current page, the dispatcher, whatever
 * It is static to avoid the injection hell.
 */
abstract class PageContext {
	/**
	 * The page currently active
	 * 
	 * @var \nexxes\Page
	 */
	public static $page;
	
	/**
	 * Request variables and link builder
	 * 
	 * @var \nexxes\helper\RequestData
	 */
	public static $request;
	
	/**
	 * A template engine instance to use
	 * 
	 * @var \Smarty
	 */
	public static $smarty;
	
	/**
	 * Accessor for widget properties extracted from annotations
	 * 
	 * @var \nexxes\property\Handler
	 */
	public static $propertyHandler;
	
	/**
	 * The widget registry hold references to all widgets and ensures unique identifiers
	 * 
	 * @var \nexxes\helper\WidgetRegistry
	 */
	public static $widgetRegistry;
}
