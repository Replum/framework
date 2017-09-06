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
     * @return static $this
     * @see \Replum\WidgetHasChangeEventInterface::onChange()
     */
    final public function onChange(callable $eventHandler, int $prio = 5) : WidgetHasChangeEventInterface
    {
        return $this->on(WidgetOnChangeEvent::class, $eventHandler, $prio);
    }

    /**
     * @return static $this
     * @see \Replum\WidgetHasChangeEventInterface::onChangeOnce()
     */
    final public function onChangeOnce(callable $eventHandler, int $prio = 5) : WidgetHasChangeEventInterface
    {
        return $this->one(WidgetOnChangeEvent::class, $eventHandler, $prio);
    }

    /**
     * @return static $this
     * @see \Replum\WidgetHasChangeEventInterface::removeOnChange()
     */
    final public function removeOnChange(callable $eventHandler) : WidgetHasChangeEventInterface
    {
        return $this->off(WidgetOnChangeEvent::class, $eventHandler);
    }

    /**
     * @return static $this
     * @see \Replum\WidgetHasChangeEventInterface::removeOnChangeOnce()
     */
    final public function removeOnChangeOnce(callable $eventHandler) : WidgetHasChangeEventInterface
    {
        return $this->off(WidgetOnChangeEvent::class, $eventHandler);
    }
}
