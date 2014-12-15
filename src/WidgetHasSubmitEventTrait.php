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
		return $this->on(WidgetOnSubmitEvent::class, $eventHandler, $prio);
	}
	
	/**
	 * @see \nexxes\widgets\WidgetHasSubmitEventInterface::onSubmitOnce() WidgetHasSubmitEventInterface::onSubmitOnce()
	 */
	public function onSubmitOnce(callable $eventHandler, $prio = 5) {
		return $this->one(WidgetOnSubmitEvent::class, $eventHandler, $prio);
	}
	
	/**
	 * @see \nexxes\widgets\WidgetHasSubmitEventInterface::removeOnSubmit() WidgetHasSubmitEventInterface::removeOnSubmit()
	 */
	public function removeOnSubmit(callable $eventHandler) {
		return $this->off(WidgetOnSubmitEvent::class, $eventHandler);
	}
	
	/**
	 * @see \nexxes\widgets\WidgetHasSubmitEventInterface::removeOnSubmitOnce() WidgetHasSubmitEventInterface::removeOnSubmitOnce()
	 */
	public function removeOnSubmitOnce(callable $eventHandler) {
		return $this->off(WidgetOnSubmitEvent::class, $eventHandler);
	}
}