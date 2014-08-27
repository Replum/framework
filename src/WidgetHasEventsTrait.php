<?php

namespace nexxes\widgets;

use \nexxes\widgets\EventHandlerCallOnceWrapper;
use \Symfony\Component\EventDispatcher\EventDispatcherInterface;

trait WidgetHasEventsTrait {
	/**
	 * @implements \nexxes\widgets\WidgetHasEventsInterface
	 */
	public function registerEventHandler($eventName, callable $handler, $prio = 5) {
		$eventName = $this->_getFullEventName($eventName);
		
		$dispatcher = $this->getPage()->getEventDispatcher();
		$dispatcher->addListener($eventName, $handler, $prio);
		
		return $this;
	}
	
	/**
	 * @implements \nexxes\widgets\WidgetHasEventsInterface
	 */
	public function registerOnceEventHandler($eventName, callable $handler, $prio = 5) {
		return $this->registerEventHandler($eventName, new EventHandlerCallOnceWrapper($handler), $prio);
	}
	
	/**
	 * @implements \nexxes\widgets\WidgetHasEventsInterface
	 */
	public function removeEventHandler($eventName, callable $handler) {
		$eventName = $this->_getFullEventName($eventName);
		
		$dispatcher = $this->getPage()->getEventDispatcher();
		$dispatcher->removeListener($eventName, $handler);
		
		return $this;
	}
	
	/**
	 * @implements \nexxes\widgets\WidgetHasEventsInterface
	 */
	public function removeOnceEventHandler($eventName, callable $handler) {
		$eventName = $this->_getFullEventName($eventName);
		
		/* @var $dispatcher EventDispatcherInterface */
		$dispatcher = $this->getPage()->getEventDispatcher();
		
		foreach ($dispatcher->getListeners($eventName) AS $listener) {
			if (!($listener instanceof EventHandlerCallOnceWrapper)) {
				continue;
			}
			
			if ($listener->wrapped == $handler) {
				$dispatcher->removeListener($eventName, $listener);
				break;
			}
		}
		
		return $this;
	}
	
	/**
	 * @implements \nexxes\widgets\WidgetHasEventsInterface
	 */
	public function hasEventHandler($eventName) {
		$eventName = $this->_getFullEventName($eventName);
		return $this->getPage()->getEventDispatcher()->hasListeners($eventName);
	}
	
	private function _getFullEventName($eventName) {
		return 'widget.' . $this->getID() . '.' . $eventName;
	}
}
