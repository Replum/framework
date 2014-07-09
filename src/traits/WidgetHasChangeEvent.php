<?php

namespace nexxes\widgets\traits;

use \nexxes\widgets\interfaces\WidgetHasChangeEvent AS WidgetHasChangeEventInterface;

/**
 * Provides the methods required to implement the \nexxes\widgets\interfaces\WidgetHasChangeEvent interface
 */
trait WidgetHasChangeEvent {
	/**
	 * @implements \nexxes\widgets\interfaces\WidgetHasChangeEvent
	 */
	public function onChange(callable $eventHandler, $prio = 5) {
		return $this->registerEventHandler(WidgetHasChangeEventInterface::EVENT_NAME, $eventHandler, $prio);
	}
	
	/**
	 * @implements \nexxes\widgets\interfaces\WidgetHasChangeEvent
	 */
	public function onChangeOnce(callable $eventHandler, $prio = 5) {
		return $this->registerOnceEventHandler(WidgetHasChangeEventInterface::EVENT_NAME, $eventHandler, $prio);
	}
	
	/**
	 * @implements \nexxes\widgets\interfaces\WidgetHasChangeEvent
	 */
	public function removeOnChange(callable $eventHandler) {
		return $this->removeEventHandler(WidgetHasChangeEventInterface::EVENT_NAME, $eventHandler);
	}
	
	/**
	 * @implements \nexxes\widgets\interfaces\WidgetHasChangeEvent
	 */
	public function removeOnChangeOnce(callable $eventHandler) {
		return $this->removeOnceEventHandler(WidgetHasChangeEventInterface::EVENT_NAME, $eventHandler);
	}
	
	/**
	 * Render the change handler registration required for this widget
	 */
	protected function renderChangeHandlerHTML() {
		return ($this->hasEventHandler(WidgetHasChangeEventInterface::EVENT_NAME) ? ' onclick="nexxes.widgets.event(\'change\', this);"' : '');
	}
}
