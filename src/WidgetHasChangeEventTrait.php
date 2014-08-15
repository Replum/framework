<?php

namespace nexxes\widgets;

/**
 * Provides the methods required to implement the \nexxes\widgets\WidgetHasChangeEventInterface
 */
trait WidgetHasChangeEventTrait {
	/**
	 * @implements \nexxes\widgets\WidgetHasChangeEventInterface
	 */
	public function onChange(callable $eventHandler, $prio = 5) {
		return $this->registerEventHandler(WidgetHasChangeEventInterface::EVENT_NAME, $eventHandler, $prio);
	}
	
	/**
	 * @implements \nexxes\widgets\WidgetHasChangeEventInterface
	 */
	public function onChangeOnce(callable $eventHandler, $prio = 5) {
		return $this->registerOnceEventHandler(WidgetHasChangeEventInterface::EVENT_NAME, $eventHandler, $prio);
	}
	
	/**
	 * @implements \nexxes\widgets\WidgetHasChangeEventInterface
	 */
	public function removeOnChange(callable $eventHandler) {
		return $this->removeEventHandler(WidgetHasChangeEventInterface::EVENT_NAME, $eventHandler);
	}
	
	/**
	 * @implements \nexxes\widgets\WidgetHasChangeEventInterface
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
