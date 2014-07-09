<?php

namespace nexxes\widgets;

use \Symfony\Component\EventDispatcher\EventDispatcherInterface;

/**
 * This wrapper is used to allow to register an event handler to be executed once only.
 */
class EventHandlerCallOnceWrapper {
	/**
	 * The wrapped event handler
	 * 
	 * @var callable
	 */
	public $wrapped;
	
	public function __construct(callable $wrapped) {
		$this->wrapped = $wrapped;
	}
	
	public function __invoke(Event $event, $eventname, EventDispatcherInterface $dispatcher) {
		\call_user_func($this->wrapped, $event, $eventname, $dispatcher);
		$dispatcher->removeListener($eventname, $this);
	}
}
