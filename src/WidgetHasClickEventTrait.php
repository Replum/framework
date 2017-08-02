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

use \Replum\Events\WidgetOnClickEvent;

/**
 * Provides the methods required to implement the \Replum\WidgetHasClickEventInterface
 */
trait WidgetHasClickEventTrait
{
    /**
     * @see \Replum\WidgetHasClickEventInterface::onClick()
     */
    public function onClick(callable $eventHandler, $prio = 5)
    {
        $this->addData('handler', 'click');
        return $this->on(WidgetOnClickEvent::class, $eventHandler, $prio);
    }

    /**
     * @see \Replum\WidgetHasClickEventInterface::onClickOnce()
     */
    public function onClickOnce(callable $eventHandler, $prio = 5)
    {
        $this->addData('handler', 'click');
        return $this->one(WidgetOnClickEvent::class, $eventHandler, $prio);
    }

    /**
     * @see \Replum\WidgetHasClickEventInterface::removeOnClick()
     */
    public function removeOnClick(callable $eventHandler)
    {
        return $this->off(WidgetOnClickEvent::class, $eventHandler);
    }

    /**
     * @see \Replum\WidgetHasClickEventInterface::removeOnClickOnce()
     */
    public function removeOnClickOnce(callable $eventHandler)
    {
        return $this->off(WidgetOnClickEvent::class, $eventHandler);
    }
}
