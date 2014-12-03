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
use \nexxes\widgets\events\WidgetOnDoubleClickEvent;

/**
 * Provides the methods required to implement the \nexxes\widgets\WidgetHasDoubleClickEventInterface
 */
trait WidgetHasDoubleClickEventTrait {
	/**
	 * @implements \nexxes\widgets\WidgetHasDoubleClickEventInterface
	 */
	public function onDoubleClick(callable $eventHandler, $prio = 5) {
		/* @var $dispatcher WidgetEventDispatcher */
		$dispatcher = Container::get()[WidgetEventDispatcher::class];
		$dispatcher->addListener($dispatcher->eventName($this, WidgetOnDoubleClickEvent::class), $eventHandler, $prio);
		
		return $this;
	}
	
	/**
	 * @implements \nexxes\widgets\WidgetHasDoubleClickEventInterface
	 */
	public function onDoubleClickOnce(callable $eventHandler, $prio = 5) {
		/* @var $dispatcher WidgetEventDispatcher */
		$dispatcher = Container::get()[WidgetEventDispatcher::class];
		$dispatcher->addOnceListener($dispatcher->eventName($this, WidgetOnDoubleClickEvent::class), $eventHandler, $prio);
		
		return $this;
	}
	
	/**
	 * @implements \nexxes\widgets\WidgetHasDoubleClickEventInterface
	 */
	public function removeOnDoubleClick(callable $eventHandler) {
		/* @var $dispatcher WidgetEventDispatcher */
		$dispatcher = Container::get()[WidgetEventDispatcher::class];
		$dispatcher->removeListener($dispatcher->eventName($this, WidgetOnDoubleClickEvent::class), $eventHandler);
		
		return $this;
	}
	
	/**
	 * @implements \nexxes\widgets\WidgetHasDoubleClickEventInterface
	 */
	public function removeOnDoubleClickOnce(callable $eventHandler) {
		/* @var $dispatcher WidgetEventDispatcher */
		$dispatcher = Container::get()[WidgetEventDispatcher::class];
		$dispatcher->removeOnceListener($dispatcher->eventName($this, WidgetOnDoubleClickEvent::class), $eventHandler);
		
		return $this;
	}
}
