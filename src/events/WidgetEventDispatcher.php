<?php

/*
 * This file is part of the nexxes/widgets-base package.
 * 
 * Copyright (c) Dennis Birkholz, nexxes Informationstechnik GmbH <dennis.birkholz@nexxes.net>
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace nexxes\widgets\events;

use \nexxes\dependency\Container;
use \Psr\Log\LoggerInterface;

use \Symfony\Component\EventDispatcher\EventDispatcherInterface;
use \Symfony\Component\EventDispatcher\EventDispatcher;
use \Symfony\Component\EventDispatcher\Event;
use \nexxes\widgets\WidgetInterface;

/**
 * @author Dennis Birkholz <dennis.birkholz@nexxes.net>
 */
class WidgetEventDispatcher extends EventDispatcher {
	/**
	 * Remove a listener that should be executed only once.
	 * It is removed after it is executed.
	 * 
	 * @see EventDispatcherInterface::addListener
	 * 
	 * @param string $eventName
	 * @param callable $listener
	 * @param int $priority
	 */
	public function addOnceListener($eventName, $listener, $priority = 0) {
		$this->addListener($eventName, new EventHandlerCallOnceWrapper($listener), $priority);
	}
	
	/**
	 * Removes the first found event listener that is marked to be executed only once and the is identical to the supplied listener.
	 * 
	 * @see EventDispatcherInterface::removeListener
	 * 
	 * @param string $eventName
	 * @param callable $listener
	 */
	public function removeOnceListener($eventName, $listener) {
		foreach ($this->getListeners($eventName) as $removeCandidate) {
			if (($removeCandidate instanceof EventHandlerCallOnceWrapper) && $removeCandidate->wraps($listener)) {
				$this->removeListener($eventName, $removeCandidate);
				return;
			}
		}
	}
	
	public function dispatch($eventName, Event $event = null) {
		Container::get()[LoggerInterface::class]->addDebug(sprintf('Dispatching event %s', $eventName));
		
		if ($event instanceof WidgetEvent) {
			$listenersAllWidgetsAllEvents = $this->getListeners(self::eventName(null, '*'));
			$listenersAllWidgetsCurrentEvent = $this->getListeners(self::eventName(null, $eventName));
			
			if ($event->widget->hasID()) {
				$listenersCurrentWidgetAllEvents = $this->getListeners(self::eventName($event->widget, '*'));
				$listenersCurrentWidgetCurrentEvent = $this->getListeners(self::eventName($event->widget, $eventName));
			} else {
				$listenersCurrentWidgetAllEvents = [];
				$listenersCurrentWidgetCurrentEvent = [];
			}
			
			$listeners = \array_merge($listenersAllWidgetsAllEvents, $listenersAllWidgetsCurrentEvent, $listenersCurrentWidgetAllEvents, $listenersCurrentWidgetCurrentEvent);
			$this->doDispatch($listeners, $eventName, $event);
			return $this;
		}
		
		else {
			return parent::dispatch($eventName, $event);
		}
	}
	
	public static function eventName(WidgetInterface $widget = null, $eventName) {
		return ($widget === null ? '*' : $widget->getID()) . '|' . $eventName;
	}
}
