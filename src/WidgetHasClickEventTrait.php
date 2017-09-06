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
     * @return static $this
     * @see \Replum\WidgetHasClickEventInterface::onClick()
     */
    public function onClick(callable $eventHandler, int $prio = 5) : WidgetHasClickEventInterface
    {
        $this->addData('handler', 'click');
        return $this->on(WidgetOnClickEvent::class, $eventHandler, $prio);
    }

    /**
     * @return static $this
     * @see \Replum\WidgetHasClickEventInterface::onClickOnce()
     */
    public function onClickOnce(callable $eventHandler, int $prio = 5) : WidgetHasClickEventInterface
    {
        $this->addData('handler', 'click');
        return $this->one(WidgetOnClickEvent::class, $eventHandler, $prio);
    }

    /**
     * @return static $this
     * @see \Replum\WidgetHasClickEventInterface::removeOnClick()
     */
    public function removeOnClick(callable $eventHandler) : WidgetHasClickEventInterface
    {
        return $this->off(WidgetOnClickEvent::class, $eventHandler);
    }

    /**
     * @return static $this
     * @see \Replum\WidgetHasClickEventInterface::removeOnClickOnce()
     */
    public function removeOnClickOnce(callable $eventHandler) : WidgetHasClickEventInterface
    {
        return $this->off(WidgetOnClickEvent::class, $eventHandler);
    }
}
