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

use \Replum\WidgetInterface;

/**
 * Event dispatched when a Widget is added to a parent.
 *
 * @author Dennis Birkholz <dennis@birkholz.org>
 */
class WidgetAddEvent extends WidgetEvent
{
    /**
     * @var WidgetInterface
     */
    public $parent;

    /**
     * @param WidgetInterface $widget
     */
    public function __construct(WidgetInterface $parent, WidgetInterface $widget)
    {
        parent::__construct($widget);
        $this->parent = $parent;
    }
}
