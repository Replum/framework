<?php

/*
 * This file is part of Replum: the web widget framework.
 *
 * Copyright (c) Dennis Birkholz <dennis@birkholz.org>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Replum\Events;

use \Symfony\Component\EventDispatcher\Event;
use \Replum\WidgetInterface;

/**
 * Base class for all widget Events
 *
 * @author Dennis Birkholz <dennis@birkholz.org>
 */
abstract class WidgetEvent extends Event
{
        /**
     * @var WidgetInterface
     */
    public $widget;

    /**
     * @param WidgetInterface $widget
     */
    public function __construct(WidgetInterface $widget)
    {
        $this->widget = $widget;
    }
}
