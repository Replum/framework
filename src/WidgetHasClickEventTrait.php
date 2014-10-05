<?php

namespace nexxes\widgets;

/**
 * Provides the methods required to implement the \nexxes\widgets\WidgetHasClickEventInterface
 */
trait WidgetHasClickEventTrait {
	/**
	 * @implements \nexxes\widgets\WidgetHasClickEventInterface
	 */
	public function onClick(callable $eventHandler, $prio = 5) {
		return $this->registerEventHandler(WidgetHasClickEventInterface::EVENT_NAME, $eventHandler, $prio);
	}
	
	/**
	 * @implements \nexxes\widgets\WidgetHasClickEventInterface
	 */
	public function onClickOnce(callable $eventHandler, $prio = 5) {
		return $this->registerOnceEventHandler(WidgetHasClickEventInterface::EVENT_NAME, $eventHandler, $prio);
	}
	
	/**
	 * @implements \nexxes\widgets\WidgetHasClickEventInterface
	 */
	public function removeOnClick(callable $eventHandler) {
		return $this->removeEventHandler(WidgetHasClickEventInterface::EVENT_NAME, $eventHandler);
	}
	
	/**
	 * @implements \nexxes\widgets\WidgetHasClickEventInterface
	 */
	public function removeOnClickOnce(callable $eventHandler) {
		return $this->removeOnceEventHandler(WidgetHasClickEventInterface::EVENT_NAME, $eventHandler);
	}
	
	/**
	 * Render the click handler registration required for this widget
	 */
	protected function renderClickHandler() {
		return ($this->hasEventHandler(WidgetHasClickEventInterface::EVENT_NAME) ? ' onclick="nexxes.widgets.' . WidgetHasClickEventInterface::EVENT_NAME . '(this);"' : '');
	}
}
