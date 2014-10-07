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
 * Provides the methods required to implement the \nexxes\widgets\WidgetHasChangeEventInterface
 */
trait WidgetHasChangeEventTrait {
	/**
	 * @implements \nexxes\widgets\WidgetHasChangeEventInterface
	 */
	public function onChange(callable $eventHandler, $prio = 5) {
		/* @var $dispatcher WidgetEventDispatcher */
		$dispatcher = Container::get()[WidgetEventDispatcher::class];
		return $dispatcher->addListener(WidgetOnChangeEvent::class . ':' . $this->getID(), $eventHandler, $prio);
	}
	
	/**
	 * @implements \nexxes\widgets\WidgetHasChangeEventInterface
	 */
	public function onChangeOnce(callable $eventHandler, $prio = 5) {
		/* @var $dispatcher WidgetEventDispatcher */
		$dispatcher = Container::get()[WidgetEventDispatcher::class];
		return $dispatcher->addOnceListener(WidgetOnChangeEvent::class . ':' . $this->getID(), $eventHandler, $prio);
	}
	
	/**
	 * @implements \nexxes\widgets\WidgetHasChangeEventInterface
	 */
	public function removeOnChange(callable $eventHandler) {
		/* @var $dispatcher WidgetEventDispatcher */
		$dispatcher = Container::get()[WidgetEventDispatcher::class];
		return $dispatcher->removeListener(WidgetOnChangeEvent::class . ':' . $this->getID(), $eventHandler);
	}
	
	/**
	 * @implements \nexxes\widgets\WidgetHasChangeEventInterface
	 */
	public function removeOnChangeOnce(callable $eventHandler) {
		/* @var $dispatcher WidgetEventDispatcher */
		$dispatcher = Container::get()[WidgetEventDispatcher::class];
		return $dispatcher->removeOnceListener(WidgetOnChangeEvent::class . ':' . $this->getID(), $eventHandler);
	}
	
	/**
	 * Render the change handler registration required for this widget
	 */
	protected function renderChangeHandler() {
		/* @var $dispatcher WidgetEventDispatcher */
		$dispatcher = Container::get()[WidgetEventDispatcher::class];
		
		if ($dispatcher->hasListeners(WidgetOnChangeEvent::class . ':' . $this->getID())) {
			return ' onchange="nexxes.widgets.onchange(this);"';
		} else {
			return '';
		}
	}
}
