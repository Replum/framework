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
 * @author Dennis Birkholz <dennis@birkholz.org>
 */
trait WidgetCompositeTrait
{
    use WidgetTrait;

    /**
     * The real normalized slot definition
     * @var array
     */
    private $WidgetCompositeTraitSlots=  [];

    /**
     * The children of this widget, stored by their slot
     * @var array<\Replum\WidgetInterface>
     */
    private $WidgetCompositeTraitChildren = [];


    /**
     * @see \Replum\WidgetCompositeInterface::childSlot()
     */
    public function childSlot($name, array $allowedClasses = [ \Replum\WidgetInterface::class ]) {
        $this->WidgetCompositeTraitSlots[$name] = $allowedClasses;
    }

    /**
     * @see \ArrayAccess::offsetExists()
     */
    public function offsetExists($slot)
    {
        return isset($this->WidgetCompositeTraitChildren[$slot]);
    }

    /**
     * @see \ArrayAccess::offsetGet()
     */
    public function offsetGet($slot)
    {
        if (isset($this->WidgetCompositeTraitChildren[$slot])) {
            return $this->WidgetCompositeTraitChildren[$slot];
        }

        if (isset($this->WidgetCompositeTraitSlots[$slot])) {
            return null;
        }

        throw new \InvalidArgumentException('Access to invalid slot "' . $slot . '"');
    }

    /**
     * @See \ArrayAccess::offsetSet()
     */
    public function offsetSet($slot, $value)
    {
        if (!isset($this->WidgetCompositeTraitSlots[$slot])) {
            throw new \InvalidArgumentException('Trying to set invalid slot "' . $slot . '"');
        }

        if (isset($this->WidgetCompositeTraitChildren[$slot]) && ($this->WidgetCompositeTraitChildren[$slot] === $value)) {
            return $value;
        }

        foreach ($this->WidgetCompositeTraitSlots[$slot] AS $class) {
            if ($value instanceof $class) {
                // FIXME: unset parent of old child
                $this->WidgetCompositeTraitChildren[$slot] = $value;
                $value->setParent($this);
                $this->setChanged(true);
                return $value;
            }
        }

        throw new \InvalidArgumentException('Cannot set slot "' . $slot . '", supplied argument does not implement one of the possible classes "' . \implode('", "', $this->WidgetCompositeTraitSlots[$slot]) . '"');
    }

    /**
     * @see \ArrayAccess::offsetUnset()
     */
    public function offsetUnset($slot)
    {
        if (!isset($this->WidgetCompositeTraitSlots[$slot])) {
            throw new \InvalidArgumentException('Invalid slot "' . $slot . '"');
        }

        if (!isset($this->WidgetCompositeTraitChildren[$slot])) {
            return;
        }

        // FIXME: unset parent of old child
        unset($this->WidgetCompositeTraitChildren[$slot]);
        $this->setChanged(true);
    }

    /**
     * @see \IteratorAggregate::getIterator()
     */
    public function getIterator()
    {
        return new \ArrayIterator($this->WidgetCompositeTraitChildren);
    }

    /**
     * @see \Countable::count()
     */
    public function count()
    {
        return \count($this->WidgetCompositeTraitChildren);
    }
}
