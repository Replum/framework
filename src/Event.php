<?php

namespace nexxes\widgets;

/**
 * Event metadata container for widget events.
 * Contains the widget that fired the event.
 */
class Event extends \Symfony\Component\EventDispatcher\Event {
	public function __construct(WidgetHasEventsInterface $widget) {
		$this->widget = $widget;
	}
	
	/**
	 * @var WidgetHasEventsInterface
	 */
	private $widget;
	
	/**
	 * Get the widget that caused this event
	 * 
	 * @return \nexxes\widgets\WidgetHasEventsInterface
	 */
	public function getWidget() {
		return $this->widget;
	}
	
	/**
	 * Set the widget that caused this event
	 * 
	 * @param \nexxes\widgets\WidgetHasEventsInterface
	 */
	public function setWidget(WidgetHasEventsInterface $widget) {
		$this->widget = $widget;
	}
}
