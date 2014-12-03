<?php

/*
 * This file is part of the nexxes/widgets-base package.
 * 
 * Copyright (c) Dennis Birkholz, nexxes Informationstechnik GmbH <dennis.birkholz@nexxes.net>
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace nexxes\widgets;

use \nexxes\dependency\Container;
use \nexxes\widgets\events\WidgetEventDispatcher;
use \nexxes\widgets\events\WidgetOnSubmitEvent;

/**
 * Provides the methods required to implement the \nexxes\widgets\WidgetHasSubmitEventInterface.
 * 
 * @uses \nexxes\dependency\Container Container
 * @uses \nexxes\widgets\events\WidgetOnSubmitEvent WidgetOnSubmitEvent
 */
trait WidgetHasSubmitEventTrait {
	/**
	 * @see \nexxes\widgets\WidgetHasSubmitEventInterface::onSubmit() WidgetHasSubmitEventInterface::onSubmit()
	 */
	public function onSubmit(callable $eventHandler, $prio = 5) {
		/* @var $dispatcher WidgetEventDispatcher */
		$dispatcher = Container::get()[WidgetEventDispatcher::class];
		$dispatcher->addListener($dispatcher->eventName($this, WidgetOnSubmitEvent::class), $eventHandler, $prio);
		
		return $this;
	}
	
	/**
	 * @see \nexxes\widgets\WidgetHasSubmitEventInterface::onSubmitOnce() WidgetHasSubmitEventInterface::onSubmitOnce()
	 */
	public function onSubmitOnce(callable $eventHandler, $prio = 5) {
		/* @var $dispatcher WidgetEventDispatcher */
		$dispatcher = Container::get()[WidgetEventDispatcher::class];
		$dispatcher->addOnceListener($dispatcher->eventName($this, WidgetOnSubmitEvent::class), $eventHandler, $prio);
		
		return $this;
	}
	
	/**
	 * @see \nexxes\widgets\WidgetHasSubmitEventInterface::removeOnSubmit() WidgetHasSubmitEventInterface::removeOnSubmit()
	 */
	public function removeOnSubmit(callable $eventHandler) {
		/* @var $dispatcher WidgetEventDispatcher */
		$dispatcher = Container::get()[WidgetEventDispatcher::class];
		$dispatcher->removeListener($dispatcher->eventName($this, WidgetOnSubmitEvent::class), $eventHandler);
		
		return $this;
	}
	
	/**
	 * @see \nexxes\widgets\WidgetHasSubmitEventInterface::removeOnSubmitOnce() WidgetHasSubmitEventInterface::removeOnSubmitOnce()
	 */
	public function removeOnSubmitOnce(callable $eventHandler) {
		/* @var $dispatcher WidgetEventDispatcher */
		$dispatcher = Container::get()[WidgetEventDispatcher::class];
		$dispatcher->removeOnceListener($dispatcher->eventName($this, WidgetOnSubmitEvent::class), $eventHandler);
		
		return $this;
	}
}
