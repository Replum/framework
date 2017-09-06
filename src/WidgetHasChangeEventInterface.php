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
 * This interface indicates that the client-side (HTML) representation of this widget can fire the "change" event.
 * Handler registration implies the registration of the corresponding JavaScript event handler on the client side.
 *
 * Widgets with events must have an ID, otherwise events can not be mapped to the originating widget.
 * If you do not assign an event handler in the original page creation but in another event handler,
 * ensure to call needID() in the original page creation so the later assigned handler can work.
 *
 * You should not implement that methods provided by this interface yourself.
 * Instead, use the implementation in the {@see WidgetHasChangeEventTrait WidgetHasChangeEventTrait}.
 *
 * #### Warning
 * You must not register closures as event handlers as PHP closures can not be serialized.
 * This results in errors when any handler is executed and effectively disables handlers.
 */
interface WidgetHasChangeEventInterface extends WidgetInterface
{
    /**
     * Register a handler for the change event.
     * Multiple handler methods can be registered with this method.
     * They are called in the order they are registered.
     *
     * @param callable $eventHandler
     * @param int $prio
     * @return static $this
     */
    function onChange(callable $eventHandler, int $prio = 5) : self;

    /**
     * Register a handler for the change event that is only executed on the first occurence of the event and removed afterwards.
     * Multiple handler methods can be registered with this method.
     *
     * @param callable $eventHandler
     * @param int $prio
     * @return static $this
     */
    function onChangeOnce(callable $eventHandler, int $prio = 5) : self;

    /**
     * Remove a previously registered event handler.
     *
     * @param callable $eventHandler
     * @return static $this
     */
    function removeOnChange(callable $eventHandler) : self;

    /**
     * Remove a previously registered event handler.
     *
     * @param callable $eventHandler
     * @return static $this
     */
    function removeOnChangeOnce(callable $eventHandler) : self;
}
