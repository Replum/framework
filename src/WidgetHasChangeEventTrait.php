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

use \Replum\Events\WidgetOnChangeEvent;

/**
 * Provides the methods required to implement the \Replum\WidgetHasChangeEventInterface.
 *
 * @uses \Replum\Events\WidgetOnChangeEvent WidgetOnChangeEvent
 */
trait WidgetHasChangeEventTrait
{
    /**
     * @see \Replum\WidgetHasChangeEventInterface::onChange()
     */
    public function onChange(callable $eventHandler, $prio = 5)
    {
        return $this->on(WidgetOnChangeEvent::class, $eventHandler, $prio);
    }

    /**
     * @see \Replum\WidgetHasChangeEventInterface::onChangeOnce()
     */
    public function onChangeOnce(callable $eventHandler, $prio = 5)
    {
        return $this->one(WidgetOnChangeEvent::class, $eventHandler, $prio);
    }

    /**
     * @see \Replum\WidgetHasChangeEventInterface::removeOnChange()
     */
    public function removeOnChange(callable $eventHandler)
    {
        return $this->off(WidgetOnChangeEvent::class, $eventHandler);
    }

    /**
     * @see \Replum\WidgetHasChangeEventInterface::removeOnChangeOnce()
     */
    public function removeOnChangeOnce(callable $eventHandler)
    {
        return $this->off(WidgetOnChangeEvent::class, $eventHandler);
    }
}
