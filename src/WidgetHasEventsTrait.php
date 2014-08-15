<?php

namespace nexxes\widgets;

use \nexxes\dependency\Gateway as dep;
use \nexxes\widgets\EventHandlerCallOnceWrapper;
use \Symfony\Component\EventDispatcher\EventDispatcherInterface;

trait WidgetHasEventsTrait {
	/**
	 * @implements \nexxes\widgets\WidgetHasEventsInterface
	 */
	public function registerEventHandler($eventName, callable $handler, $prio = 5) {
		$eventName = $this->_getFullEventName($eventName);
		
		/* @var $dispatcher EventDispatcherInterface */
		$dispatcher = dep::get(EventDispatcherInterface::class);
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
		
		/* @var $dispatcher EventDispatcherInterface */
		$dispatcher = dep::get(EventDispatcherInterface::class);
		$dispatcher->removeListener($eventName, $handler);
		
		return $this;
	}
	
	/**
	 * @implements \nexxes\widgets\WidgetHasEventsInterface
	 */
	public function removeOnceEventHandler($eventName, callable $handler) {
		$eventName = $this->_getFullEventName($eventName);
		
		/* @var $dispatcher EventDispatcherInterface */
		$dispatcher = dep::get(EventDispatcherInterface::class);
		
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
		
		/* @var $dispatcher EventDispatcherInterface */
		$dispatcher = dep::get(EventDispatcherInterface::class);
		
		return $dispatcher->hasListeners($eventName);
	}
	
	
	private function _getFullEventName($eventName) {
		return 'widget.' . $this->getID() . '.' . $eventName;
	}
}


