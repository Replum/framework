<?php

/*
 * This file is part of the nexxes/widgets-html package.
 * 
 * Copyright (c) Dennis Birkholz, nexxes Informationstechnik GmbH <dennis.birkholz@nexxes.net>
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace nexxes\widgets\html;

use \nexxes\widgets\events\WidgetAddEvent;
use \nexxes\widgets\events\WidgetRemoveEvent;

/**
 * Uses lifecycle events to manage elements collections of forms and to set the form of each element.
 *
 * @author Dennis Birkholz <dennis.birkholz@nexxes.net>
 */
class FormSynchronizer implements \Symfony\Component\EventDispatcher\EventSubscriberInterface {
	/**
	 * @var array<FormElementInterface>
	 */
	private $unassigned = [];
	
	public static function getSubscribedEvents() {
		return [
			WidgetAddEvent::class => 'handleWidgetAddEvent',
			WidgetRemoveEvent::class => 'handleWidgetRemoveEvent',
		];
	}
	
	/**
	 * Event handler that synchronized the elements array of the form.
	 * 
	 * @param WidgetAddEvent $event
	 */
	public function handleWidgetAddEvent(WidgetAddEvent $event) {
		if ($event->widget instanceof FormElementInterface) {
			//echo "Widget of type " . \get_class($event->widget) . " added\n";
			
			$this->unassigned[] = $event->widget;
		}
		
		// Work all unassigned forms
		foreach ($this->unassigned as $key => $widget) {
			//echo "checking Widget of type " . \get_class($widget) . "\n";
			
			$ancestors = $widget->getAncestors(Form::class);
		
			// Error
			if (count($ancestors) > 1) { throw new \RuntimeException('A form element can not exists within nested form elements!'); }
			
			// Element is not inside a form
			if (count($ancestors) === 0) { continue; }
			
			// Assign form for widget
			//echo "Assigning form " . $ancestors[0]->getID() . ' to widget ' . $widget->getID() . "<br>\n";
			$ancestors[0]->getElements()->add($widget);
			$widget->setForm($ancestors[0]);
			unset($this->unassigned[$key]);
		}
	}
	
	/**
	 * Event handler that synchronized the elements array of the form.
	 * 
	 * @param WidgetRemoveEvent $event
	 */
	public function handleWidgetRemoveEvent(WidgetRemoveEvent $event) {
		if (!($event->widget instanceof FormElementInterface)) { return; }
		
		$form = $event->widget->getForm();
		if (is_null($form)) { return; }
		
		$form->getElements()->remove($event->widget);
	}
}
