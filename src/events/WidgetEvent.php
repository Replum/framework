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

use \Symfony\Component\EventDispatcher\Event;
use \nexxes\widgets\WidgetInterface;

/**
 * Base class for all widget events
 * 
 * @author Dennis Birkholz <dennis.birkholz@nexxes.net>
 */
abstract class WidgetEvent extends Event {
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
