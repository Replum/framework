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
use \nexxes\widgets\events\WidgetOnClickEvent;

/**
 * Provides the methods required to implement the \nexxes\widgets\WidgetHasClickEventInterface
 */
trait WidgetHasClickEventTrait {
	/**
	 * @implements \nexxes\widgets\WidgetHasClickEventInterface
	 */
	public function onClick(callable $eventHandler, $prio = 5) {
		/* @var $dispatcher WidgetEventDispatcher */
		$dispatcher = Container::get()[WidgetEventDispatcher::class];
		$dispatcher->addListener($dispatcher->eventName($this, WidgetOnClickEvent::class), $eventHandler, $prio);
		
		return $this;
	}
	
	/**
	 * @implements \nexxes\widgets\WidgetHasClickEventInterface
	 */
	public function onClickOnce(callable $eventHandler, $prio = 5) {
		/* @var $dispatcher WidgetEventDispatcher */
		$dispatcher = Container::get()[WidgetEventDispatcher::class];
		$dispatcher->addOnceListener($dispatcher->eventName($this, WidgetOnClickEvent::class), $eventHandler, $prio);
		
		return $this;
	}
	
	/**
	 * @implements \nexxes\widgets\WidgetHasClickEventInterface
	 */
	public function removeOnClick(callable $eventHandler) {
		/* @var $dispatcher WidgetEventDispatcher */
		$dispatcher = Container::get()[WidgetEventDispatcher::class];
		$dispatcher->removeListener($dispatcher->eventName($this, WidgetOnClickEvent::class), $eventHandler);
		
		return $this;
	}
	
	/**
	 * @implements \nexxes\widgets\WidgetHasClickEventInterface
	 */
	public function removeOnClickOnce(callable $eventHandler) {
		/* @var $dispatcher WidgetEventDispatcher */
		$dispatcher = Container::get()[WidgetEventDispatcher::class];
		$dispatcher->removeOnceListener($dispatcher->eventName($this, WidgetOnClickEvent::class), $eventHandler);
		
		return $this;
	}
}
