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
     * @see \Replum\WidgetHasDoubleClickEventInterface::onDoubleClick()
     */
    public function onDoubleClick(callable $eventHandler, $prio = 5)
    {
        $this->addData('handler', 'dblclick');
        return $this->on(WidgetOnDoubleClickEvent::class, $eventHandler, $prio);
    }

    /**
     * @see \Replum\WidgetHasDoubleClickEventInterface::onDoubleClickOnce()
     */
    public function onDoubleClickOnce(callable $eventHandler, $prio = 5)
    {
        $this->addData('handler', 'dblclick');
        return $this->one(WidgetOnDoubleClickEvent::class, $eventHandler, $prio);
    }

    /**
     * @see \Replum\WidgetHasDoubleClickEventInterface::removeOnDoubleClick()
     */
    public function removeOnDoubleClick(callable $eventHandler)
    {
        return $this->off(WidgetOnDoubleClickEvent::class, $eventHandler);
    }

    /**
     * @see \Replum\WidgetHasDoubleClickEventInterface::removeOnDoubleClickOnce()
     */
    public function removeOnDoubleClickOnce(callable $eventHandler)
    {
        return $this->off(WidgetOnDoubleClickEvent::class, $eventHandler);
    }
}
