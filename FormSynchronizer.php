<?php

/*
 * This file is part of the nexxes/widgets package.
 *
 * Copyright (C) 2014 Dennis Birkholz <dennis.birkholz@nexxes.net>.
 *
 * This library is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Lesser General Public License as
 * published by the Free Software Foundation, either version 3 of
 * the License, or (at your option) any later version.
 *
 * This library is distributed in the hope that it will be useful, but
 * WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 * See the GNU Lesser General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public
 * License along with this library; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston,
 * MA 02110-1301  USA
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
