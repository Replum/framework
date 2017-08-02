<?php

/*
 * This file is part of Replum: the web widget framework.
 *
 * Copyright (c) Dennis Birkholz <dennis@birkholz.org>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Replum;

/**
 * A composite is a widget that is composed from other widgets.
 * Each child of the composite has a unique name/position within the composite.
 * The named child slots are created with the childSlot() method inside the constructor and can be filled by using the ArrayAccess method:
 * <code>
 * $widgetcomposite = new WidgetComposite();
 * $widgetcomposite["childname"] = new ChildWidget();
 * </code>
 */
interface WidgetCompositeInterface extends WidgetInterface, \ArrayAccess, \Countable, \IteratorAggregate
{
    /**
     * Create a new child slot.
     *
     * @param string $name The composite unique slot name
     * @param array<string> $allowedClasses List of possible classes/interfaces allowed for this slot
     */
    function childSlot($name, array $allowedClasses = [ \Replum\WidgetInterface::class ]);
}
