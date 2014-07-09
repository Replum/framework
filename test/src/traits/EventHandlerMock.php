<?php

namespace nexxes\widgets\traits;

use \nexxes\widgets\Event;
use \Symfony\Component\EventDispatcher\EventDispatcherInterface;

class EventHandlerMock {
	public $counter = 0;
	
	/**
	 * Name of the last event fired
	 * @var string
	 */
	public $eventname = '';
	
	public function handler(Event $event, $eventname, EventDispatcherInterface $dispatcher) {
		$this->counter++;
		$this->eventname = $eventname;
	}
}
