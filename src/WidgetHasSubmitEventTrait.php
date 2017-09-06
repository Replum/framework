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
     * @return static $this
     * @see \Replum\WidgetHasSubmitEventInterface::onSubmit()
     */
    final public function onSubmit(callable $eventHandler, int $prio = 5) : WidgetHasSubmitEventInterface
    {
        return $this->on(WidgetOnSubmitEvent::class, $eventHandler, $prio);
    }

    /**
     * @return static $this
     * @see \Replum\WidgetHasSubmitEventInterface::onSubmitOnce()
     */
    final public function onSubmitOnce(callable $eventHandler, int $prio = 5) : WidgetHasSubmitEventInterface
    {
        return $this->one(WidgetOnSubmitEvent::class, $eventHandler, $prio);
    }

    /**
     * @return static $this
     * @see \Replum\WidgetHasSubmitEventInterface::removeOnSubmit()
     */
    final public function removeOnSubmit(callable $eventHandler) : WidgetHasSubmitEventInterface
    {
        return $this->off(WidgetOnSubmitEvent::class, $eventHandler);
    }

    /**
     * @return static $this
     * @see \Replum\WidgetHasSubmitEventInterface::removeOnSubmitOnce()
     */
    final public function removeOnSubmitOnce(callable $eventHandler) : WidgetHasSubmitEventInterface
    {
        return $this->off(WidgetOnSubmitEvent::class, $eventHandler);
    }
}
