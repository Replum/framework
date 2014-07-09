<?php

namespace nexxes\widgets\interfaces;

/**
 * Mark a widget as capable of emiting events.
 */
interface WidgetHasEvents extends Identifiable {
	/**
	 * Register the supplied callback as an event handler for the named event with the given priority.
	 * 
	 * @param string $eventName
	 * @param callable $handler
	 * @param int $prio
	 * @return WidgetHasEvents $this for chaining
	 */
	function registerEventHandler($eventName, callable $handler, $prio = 5);
	
	/**
	 * Register the supplied callback as an event handler for the named event with the given priority.
	 * The event handler is executed only once and the removed.
	 * 
	 * @param string $eventName
	 * @param callable $handler
	 * @param int $prio
	 * @return WidgetHasEvents $this for chaining
	 */
	function registerOnceEventHandler($eventName, callable $handler, $prio = 5);
	
	/**
	 * Remove the supplied event handler from this widget.
	 * 
	 * @param string $eventname
	 * @param callable $handler
	 * @return WidgetHasEvents $this for chaining
	 */
	function removeEventHandler($eventname, callable $handler);
	
	/**
	 * Remove the supplied event handler from this widget.
	 * 
	 * @param string $eventName
	 * @param callable $handler
	 * @return WidgetHasEvents $this for chaining
	 */
	function removeOnceEventHandler($eventName, callable $handler);
	
	/**
	 * Check if event handlers are registered for the supplied event
	 * 
	 * @param string $eventName
	 * @return bool
	 */
	function hasEventHandler($eventName);
}
