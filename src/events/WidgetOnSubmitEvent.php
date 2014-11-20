<?php

/*
 * This file is part of the nexxes/widgets-base package.
 * 
 * Copyright (c) Dennis Birkholz, nexxes Informationstechnik GmbH <dennis.birkholz@nexxes.net>
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace nexxes\widgets\events;

use \nexxes\widgets\WidgetInterface;
use \Symfony\Component\EventDispatcher\Event;

/**
 * @author Dennis Birkholz <dennis.birkholz@nexxes.net>
 */
class WidgetOnSubmitEvent extends Event {
	/**
	 * @var WidgetInterface
	 */
	public $widget;
	
	/**
	 * @param WidgetInterface $widget
	 */
	public function __construct(WidgetInterface $widget) {
		$this->widget = $widget;
	}
}
