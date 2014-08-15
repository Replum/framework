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
	 * @var interfaces\WidgetHasEvents
	 */
	private $widget;
	
	/**
	 * Get the widget that caused this event
	 * 
	 * @return \nexxes\widgets\WidgetInterface
	 */
	public function getWidget() {
		return $this->widget;
	}
	
	/**
	 * Set the widget that caused this event
	 * 
	 * @param \nexxes\widgets\WidgetInterface
	 */
	public function setWidget(WidgetInterface $widget) {
		$this->widget = $widget;
	}
}
