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

use \Replum\Events\WidgetOnDoubleClickEvent;

/**
 * Provides the methods required to implement the \Replum\WidgetHasDoubleClickEventInterface
 */
trait WidgetHasDoubleClickEventTrait
{
    /**
     * @return static $this
     * @see \Replum\WidgetHasDoubleClickEventInterface::onDoubleClick()
     */
    final public function onDoubleClick(callable $eventHandler, int $prio = 5) : WidgetHasDoubleClickEventInterface
    {
        $this->addData('handler', 'dblclick');
        return $this->on(WidgetOnDoubleClickEvent::class, $eventHandler, $prio);
    }

    /**
     * @return static $this
     * @see \Replum\WidgetHasDoubleClickEventInterface::onDoubleClickOnce()
     */
    final public function onDoubleClickOnce(callable $eventHandler, int $prio = 5) : WidgetHasDoubleClickEventInterface
    {
        $this->addData('handler', 'dblclick');
        return $this->one(WidgetOnDoubleClickEvent::class, $eventHandler, $prio);
    }

    /**
     * @return static $this
     * @see \Replum\WidgetHasDoubleClickEventInterface::removeOnDoubleClick()
     */
    final public function removeOnDoubleClick(callable $eventHandler) : WidgetHasDoubleClickEventInterface
    {
        return $this->off(WidgetOnDoubleClickEvent::class, $eventHandler);
    }

    /**
     * @return static $this
     * @see \Replum\WidgetHasDoubleClickEventInterface::removeOnDoubleClickOnce()
     */
    final public function removeOnDoubleClickOnce(callable $eventHandler) : WidgetHasDoubleClickEventInterface
    {
        return $this->off(WidgetOnDoubleClickEvent::class, $eventHandler);
    }
}
