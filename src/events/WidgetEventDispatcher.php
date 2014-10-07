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

use \Symfony\Component\EventDispatcher\EventDispatcherInterface;
use \Symfony\Component\EventDispatcher\EventDispatcher;

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
}
