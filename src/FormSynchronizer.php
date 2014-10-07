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
		if (!($event->widget instanceof FormElementInterface)) { return; }
		
		$ancestors = $event->widget->getAncestors(Form::class);
		
		// Form element is not inside a form
		if (count($ancestors) === 0) { return; }
		// Error
		if (count($ancestors) > 1) { throw new \RuntimeException('A form element can not exists within nested form elements!'); }
		
		$ancestors[0]->elements()->add($event->widget);
		$event->widget->setForm($ancestors[0]);
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
		
		$form->elements()->remove($event->widget);
	}
}
