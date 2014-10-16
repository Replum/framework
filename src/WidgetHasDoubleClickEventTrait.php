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
		return $dispatcher->addListener(WidgetOnDoubleClickEvent::class . ':' . $this->getID(), $eventHandler, $prio);
	}
	
	/**
	 * @implements \nexxes\widgets\WidgetHasDoubleClickEventInterface
	 */
	public function onDoubleClickOnce(callable $eventHandler, $prio = 5) {
		/* @var $dispatcher WidgetEventDispatcher */
		$dispatcher = Container::get()[WidgetEventDispatcher::class];
		return $dispatcher->addOnceListener(WidgetOnDoubleClickEvent::class . ':' . $this->getID(), $eventHandler, $prio);
	}
	
	/**
	 * @implements \nexxes\widgets\WidgetHasDoubleClickEventInterface
	 */
	public function removeOnDoubleClick(callable $eventHandler) {
		/* @var $dispatcher WidgetEventDispatcher */
		$dispatcher = Container::get()[WidgetEventDispatcher::class];
		return $dispatcher->removeListener(WidgetOnDoubleClickEvent::class . ':' . $this->getID(), $eventHandler);
	}
	
	/**
	 * @implements \nexxes\widgets\WidgetHasDoubleClickEventInterface
	 */
	public function removeOnDoubleClickOnce(callable $eventHandler) {
		/* @var $dispatcher WidgetEventDispatcher */
		$dispatcher = Container::get()[WidgetEventDispatcher::class];
		return $dispatcher->removeOnceListener(WidgetOnDoubleClickEvent::class . ':' . $this->getID(), $eventHandler);
	}
	
	/**
	 * Render the click handler registration required for this widget
	 */
	protected function renderDoubleClickHandler() {
		/* @var $dispatcher WidgetEventDispatcher */
		$dispatcher = Container::get()[WidgetEventDispatcher::class];
		
		if ($dispatcher->hasListeners(WidgetOnDoubleClickEvent::class . ':' . $this->getID())) {
			return ' ondblclick="nexxes.widgets.ondoubleclick(this);"';
		} else {
			return '';
		}
	}
}
