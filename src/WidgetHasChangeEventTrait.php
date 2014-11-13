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
use \nexxes\widgets\events\WidgetOnChangeEvent;

/**
 * Provides the methods required to implement the \nexxes\widgets\WidgetHasChangeEventInterface.
 * 
 * @uses \nexxes\dependency\Container Container
 * @uses \nexxes\widgets\events\WidgetOnChangeEvent WidgetOnChangeEvent
 */
trait WidgetHasChangeEventTrait {
	/**
	 * @see \nexxes\widgets\WidgetHasChangeEventInterface::onChange() WidgetHasChangeEventInterface::onChange()
	 */
	public function onChange(callable $eventHandler, $prio = 5) {
		/* @var $dispatcher WidgetEventDispatcher */
		$dispatcher = Container::get()[WidgetEventDispatcher::class];
		$dispatcher->addListener(WidgetOnChangeEvent::class . ':' . $this->getID(), $eventHandler, $prio);
		
		return $this;
	}
	
	/**
	 * @see \nexxes\widgets\WidgetHasChangeEventInterface::onChangeOnce() WidgetHasChangeEventInterface::onChangeOnce()
	 */
	public function onChangeOnce(callable $eventHandler, $prio = 5) {
		/* @var $dispatcher WidgetEventDispatcher */
		$dispatcher = Container::get()[WidgetEventDispatcher::class];
		$dispatcher->addOnceListener(WidgetOnChangeEvent::class . ':' . $this->getID(), $eventHandler, $prio);
		
		return $this;
	}
	
	/**
	 * @see \nexxes\widgets\WidgetHasChangeEventInterface::removeOnChange() WidgetHasChangeEventInterface::removeOnChange()
	 */
	public function removeOnChange(callable $eventHandler) {
		/* @var $dispatcher WidgetEventDispatcher */
		$dispatcher = Container::get()[WidgetEventDispatcher::class];
		$dispatcher->removeListener(WidgetOnChangeEvent::class . ':' . $this->getID(), $eventHandler);
		
		return $this;
	}
	
	/**
	 * @see \nexxes\widgets\WidgetHasChangeEventInterface::removeOnChangeOnce() WidgetHasChangeEventInterface::removeOnChangeOnce()
	 */
	public function removeOnChangeOnce(callable $eventHandler) {
		/* @var $dispatcher WidgetEventDispatcher */
		$dispatcher = Container::get()[WidgetEventDispatcher::class];
		$dispatcher->removeOnceListener(WidgetOnChangeEvent::class . ':' . $this->getID(), $eventHandler);
		
		return $this;
	}
}
