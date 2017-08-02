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

use \Replum\Events\WidgetOnSubmitEvent;

/**
 * Provides the methods required to implement the \Replum\WidgetHasSubmitEventInterface.
 *
 * @uses \Replum\Events\WidgetOnSubmitEvent WidgetOnSubmitEvent
 */
trait WidgetHasSubmitEventTrait
{
    /**
     * @see \Replum\WidgetHasSubmitEventInterface::onSubmit()
     */
    public function onSubmit(callable $eventHandler, $prio = 5)
    {
        return $this->on(WidgetOnSubmitEvent::class, $eventHandler, $prio);
    }

    /**
     * @see \Replum\WidgetHasSubmitEventInterface::onSubmitOnce()
     */
    public function onSubmitOnce(callable $eventHandler, $prio = 5)
    {
        return $this->one(WidgetOnSubmitEvent::class, $eventHandler, $prio);
    }

    /**
     * @see \Replum\WidgetHasSubmitEventInterface::removeOnSubmit()
     */
    public function removeOnSubmit(callable $eventHandler)
    {
        return $this->off(WidgetOnSubmitEvent::class, $eventHandler);
    }

    /**
     * @see \Replum\WidgetHasSubmitEventInterface::removeOnSubmitOnce()
     */
    public function removeOnSubmitOnce(callable $eventHandler)
    {
        return $this->off(WidgetOnSubmitEvent::class, $eventHandler);
    }
}
