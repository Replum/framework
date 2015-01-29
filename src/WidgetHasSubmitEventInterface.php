<?php

/*
 * This file is part of the nexxes/widgets-base package.
 *
 * Copyright (c) Dennis Birkholz, nexxes Informationstechnik GmbH <dennis.birkholz@nexxes.net>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace nexxes\widgets;

/**
 * This interface indicates that the client-side (HTML) representation of this widget can fire the "submit" event.
 * The "submit" event can only be fired by forms but the implementation is agnostic to this html implementation "detail".
 * Handler registration implies the registration of the corresponding JavaScript event handler on the client side.
 *
 * Widgets with events must have an ID, otherwise events can not be mapped to the originating widget.
 * If you do not assign an event handler in the original page creation but in another event handler,
 * ensure to call needID() in the original page creation so the later assigned handler can work.
 *
 * You should not implement that methods provided by this interface yourself.
 * Instead, use the implementation in the {@see WidgetHasSubmitEventTrait WidgetHasSubmitEventTrait}.
 *
 * #### Warning
 * You must not register closures as event handlers as PHP closures can not be serialized.
 * This results in errors when any handler is executed and effectively disables handlers.
 */
interface WidgetHasSubmitEventInterface extends WidgetInterface
{

    /**
     * Register a handler for the submit event.
     * Multiple handler methods can be registered with this method.
     * They are called in the order they are registered.
     *
     * @param callable $eventHandler
     * @param int $prio
     * @return WidgetHasSubmitEvent $this for chaining
     */
    function onSubmit(callable $eventHandler, $prio = 5);

    /**
     * Register a handler for the submit event that is only executed on the first occurence of the event and removed afterwards.
     * Multiple handler methods can be registered with this method.
     *
     * @param callable $eventHandler
     * @param int $prio
     * @return WidgetHasSubmitEvent $this for chaining
     */
    function onSubmitOnce(callable $eventHandler, $prio = 5);

    /**
     * Remove a previously registered event handler.
     *
     * @param callable $eventHandler
     * @return WidgetHasSubmitEvent $this for chaining
     */
    function removeOnSubmit(callable $eventHandler);

    /**
     * Remove a previously registered event handler.
     *
     * @param callable $eventHandler
     * @return WidgetHasSubmitEvent $this for chaining
     */
    function removeOnSubmitOnce(callable $eventHandler);
}
