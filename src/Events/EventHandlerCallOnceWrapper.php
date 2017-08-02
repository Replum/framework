<?php

/*
 * This file is part of Replum: the web widget framework.
 *
 * Copyright (c) Dennis Birkholz <dennis@birkholz.org>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Replum\Events;

use \Symfony\Component\EventDispatcher\EventDispatcherInterface;
use \Symfony\Component\EventDispatcher\Event;

/**
 * This wrapper is used to allow to register an event handler to be executed once only.
 */
class EventHandlerCallOnceWrapper
{
    /**
     * The wrapped event handler
     *
     * @var callable
     */
    private $wrapped;


    /**
     * @param callable $wrapped
     */
    public function __construct(callable $wrapped)
    {
        $this->wrapped = $wrapped;
    }

    /**
     * Remove wrapper and registered event handler from dispatcher
     *
     * @param Event $event
     * @param string $eventname
     * @param EventDispatcherInterface $dispatcher
     */
    public function __invoke(Event $event, $eventname, EventDispatcherInterface $dispatcher)
    {
        \call_user_func($event, $eventname, $dispatcher);
        $dispatcher->removeListener($eventname, $this);
    }

    /**
     * Test if the supplied callback is contained within this wrapper
     *
     * @param callable $callback
     * @return boolean
     */
    public function wraps(callable $callback)
    {
        return ($this->wrapped === $callback);
    }
}
