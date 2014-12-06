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

use \nexxes\widgets\events\WidgetOnDoubleClickEvent;

/**
 * Provides the methods required to implement the \nexxes\widgets\WidgetHasDoubleClickEventInterface
 */
trait WidgetHasDoubleClickEventTrait {
	/**
	 * @implements \nexxes\widgets\WidgetHasDoubleClickEventInterface
	 */
	public function onDoubleClick(callable $eventHandler, $prio = 5) {
		return $this->on(WidgetOnDoubleClickEvent::class, $eventHandler, $prio);
	}
	
	/**
	 * @implements \nexxes\widgets\WidgetHasDoubleClickEventInterface
	 */
	public function onDoubleClickOnce(callable $eventHandler, $prio = 5) {
		return $this->one(WidgetOnDoubleClickEvent::class, $eventHandler, $prio);
	}
	
	/**
	 * @implements \nexxes\widgets\WidgetHasDoubleClickEventInterface
	 */
	public function removeOnDoubleClick(callable $eventHandler) {
		return $this->off(WidgetOnDoubleClickEvent::class, $eventHandler, $prio);
	}
	
	/**
	 * @implements \nexxes\widgets\WidgetHasDoubleClickEventInterface
	 */
	public function removeOnDoubleClickOnce(callable $eventHandler) {
		return $this->off(WidgetOnDoubleClickEvent::class, $eventHandler, $prio);
	}
}
