<?php

namespace nexxes\widgets;

/**
 * Event metadata container for widget events.
 * Contains the widget that fired the event.
 */
class Event extends \Symfony\Component\EventDispatcher\Event {
	public function __construct(interfaces\WidgetHasEvents $widget) {
		$this->widget = $widget;
	}
	
	/**
	 * @var interfaces\WidgetHasEvents
	 */
	private $widget;
	
	/**
	 * Get the widget that caused this event
	 * 
	 * @return interfaces\WidgetHasEvents
	 */
	public function getWidget() {
		return $this->widget;
	}
	
	/**
	 * Set the widget that caused this event
	 * 
	 * @param interfaces\WidgetHasEvents $widget
	 */
	public function setWidget(interfaces\Widget $widget) {
		$this->widget = $widget;
	}
}
