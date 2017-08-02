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
 * Event dispatched when a Widget is changed the first time after page creation or after restoring the page in a sub request.
 *
 * @author Dennis Birkholz <dennis@birkholz.org>
 */
class WidgetChangeEvent extends WidgetEvent
{
    /**
     * The name of the changed property of the widget
     * @var string
     */
    public $property;

    /**
     * @var mixed
     */
    public $oldValue;

    /**
     * @var mixed
     */
    public $newValue;

    /**
     * @param WidgetInterface $widget
     * @param string $property
     * @param mixed $oldValue
     * @param mixed $newValue
     */
    public function __construct(WidgetInterface $widget, $property = null, $oldValue = null, $newValue = null)
    {
        parent::__construct($widget);
        $this->property = $property;
        $this->oldValue = $oldValue;
        $this->newValue = $newValue;
    }
}
