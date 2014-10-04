<?php

namespace nexxes\widgets;

/**
 * This interface indicates that the client-side (HTML) representation of this widget can fire the "click" event.
 * Handler registration implies the registration of the corresponding JavaScript event handler on the client side.
 * 
 * Event handler should be stored in the EventHandlerRegistry so the handler are executed by the Executer.
 * 
 * NOTE: You must not register closures as event handler as PHP closures can not be serialized and thus can not be called when the widget is restored (unserialized) on the event.
 */
interface WidgetHasClickEventInterface extends WidgetHasEventsInterface {
	/**
	 * Suffix used to build event names
	 */
	const EVENT_NAME = "onclick";
	
	/**
	 * Register a handler for the click event.
	 * Multiple handler methods can be registered with this method.
	 * They are called in the order they are registered.
	 * 
	 * @param callable $eventHandler
	 * @param int $prio
	 * @return WidgetHasChangeEvent $this for chaining
	 */
	function onClick(callable $eventHandler, $prio = 5);
	
	/**
	 * Register a handler for the click event that is only executed on the first occurence of the event and removed afterwards.
	 * Multiple handler methods can be registered with this method.
	 * 
	 * @param callable $eventHandler
	 * @return WidgetHasChangeEvent $this for chaining
	 */
	function onClickOnce(callable $eventHandler, $prio = 5);
	
	/**
	 * Remove a previously registered event handler.
	 * 
	 * @param callable $eventHandler
	 * @return WidgetHasChangeEvent $this for chaining
	 */
	function removeOnClick(callable $eventHandler);
	
	/**
	 * Remove a previously registered event handler.
	 * 
	 * @param callable $eventHandler
	 * @return WidgetHasChangeEvent $this for chaining
	 */
	function removeOnClickOnce(callable $eventHandler);
}