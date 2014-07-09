<?php

namespace nexxes\widgets\interfaces;

/**
 * This interface indicates that the client-side (HTML) representation of this widget can fire the "change" event.
 * Handler registration implies the registration of the corresponding JavaScript event handler on the client side.
 * 
 * Event handler should be stored in the EventHandlerRegistry so the handler are executed by the Executer.
 * 
 * The implementation of the Identifiable interface is required. The ID of the widget must be present so the origin of the event on the client side can be mapped to the widget on the server side.
 * 
 * NOTE: You must not register closures as event handler as PHP closures can not be serialized and thus can not be called when the widget is restored (unserialized) on the event.
 */
interface WidgetHasChangeEvent extends Identifiable {
	/**
	 * Register a handler for the change event.
	 * Multiple handler methods can be registered with this method.
	 * They are called in the order they are registered.
	 * 
	 * @param callable $eventHandler
	 * @return WidgetHasChangeEvent $this for chaining
	 */
	function onChange(callable $eventHandler);
	
	/**
	 * Register a handler for the change event that is only executed on the first occurence of the event and removed afterwards.
	 * Multiple handler methods can be registered with this method.
	 * 
	 * @param callable $eventHandler
	 * @return WidgetHasChangeEvent $this for chaining
	 */
	function onChangeOnce(callable $eventHandler);
	
	/**
	 * Remove a previously registered event handler.
	 * 
	 * @param callable $eventHandler
	 * @return WidgetHasChangeEvent $this for chaining
	 */
	function removeOnChange(callable $eventHandler);
	
	/**
	 * Remove a previously registered event handler.
	 * 
	 * @param callable $eventHandler
	 * @return WidgetHasChangeEvent $this for chaining
	 */
	function removeOnChangeOnce(callable $eventHandler);
}
