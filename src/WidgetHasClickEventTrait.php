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

use \nexxes\widgets\events\WidgetOnClickEvent;

/**
 * Provides the methods required to implement the \nexxes\widgets\WidgetHasClickEventInterface
 */
trait WidgetHasClickEventTrait {
	/**
	 * @implements \nexxes\widgets\WidgetHasClickEventInterface
	 */
	public function onClick(callable $eventHandler, $prio = 5) {
		return $this->on(WidgetOnClickEvent::class, $eventHandler, $prio);
	}
	
	/**
	 * @implements \nexxes\widgets\WidgetHasClickEventInterface
	 */
	public function onClickOnce(callable $eventHandler, $prio = 5) {
		return $this->one(WidgetOnClickEvent::class, $eventHandler, $prio);
	}
	
	/**
	 * @implements \nexxes\widgets\WidgetHasClickEventInterface
	 */
	public function removeOnClick(callable $eventHandler) {
		return $this->off(WidgetOnClickEvent::class, $eventHandler);
	}
	
	/**
	 * @implements \nexxes\widgets\WidgetHasClickEventInterface
	 */
	public function removeOnClickOnce(callable $eventHandler) {
		return $this->off(WidgetOnClickEvent::class, $eventHandler);
	}
}
