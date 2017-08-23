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

use \Replum\Events\WidgetEvent;

/**
 * Base interface for all widgets
 */
interface WidgetInterface
{
    /**
     * Get the internal identifier for the widget, preserved after page restore
     */
    function getWidgetId() : string;

    /**
     * Get the page this widget belongs to
     */
    function getPage() : PageInterface;

    /**
     * Check if the selected widget is the topmost widget aka the page
     */
    function isRoot() : bool;

    /**
     * Get the parent of this widget, used to navigate to the top of the widget tree.
     */
    function getParent() : self;

    /**
     * Set the current parent widget for the current widget.
     * Should not called directly to avoid creating corrupt widget hierarchies.
     * Instead this method should be called from a container when a widget is added to that container.
     *
     * @return $this
     */
    function setParent(self $newParent) : self;

    /**
     * Unset the parent, used to trigger WidgetRemoveEvent handler
     *
     * @return $this
     */
    function clearParent() : self;

    /**
     * Get the owner of this widget.
     * In most cases, the parent of the widget is also the owner.
     * For child widgets of compound widgets this allows to directly access the compound widget itself
     *  instead of some structural container widget in between them.
     */
    //function getOwner() : WidgetContainerInterface;

    /**
     * Change the owner
     *
     * @return $this
     */
    //function setOwner(WidgetContainerInterface $owner) : self;

    /**
     * Return the complete list of ancestors of this widget up to the root element.
     * The first element is the parent and the last element is the root.
     * If $filterByType is supplied, only elements that are an instance of this type are returned.
     *
     * @return \Traversable<self>
     */
    function getAncestors(string $filterByType = null) : \Traversable;

    /**
     * Get the nearest anchestor of the supplied type
     *
     * @return null|object
     */
    function getNearestAncestor(string $type);

    /**
     * Check if the widget is marked as changed
     */
    function isChanged() : bool;

    /**
     * Set/unset the changed status of the widget
     *
     * @return $this
     */
    function setChanged(bool $changed = true) : self;

    /**
     * Render the HTML representation of the widget and return it as a string
     *
     * @return string The HTML code of the widget
     */
    function render() : string;

    /**
     * Add an event handler to this widget.
     *
     * @param string $eventName
     * @param callable $listener
     * @param int $priority
     * @return static $this for chaining
     */
    function on($eventName, callable $listener, $priority = 50);

    /**
     * Add an event handler to this widget that is executed only once.
     *
     * @param string $eventName
     * @param callable $listener
     * @param int $priority
     * @return static $this for chaining
     */
    function one($eventName, callable $listener, $priority = 50);

    /**
     * Remove event handler(s) from the widget.
     * If $eventName and $listener are null, all event handlers are removed.
     * If only $listener is null, all handlers for event $eventName are removed.
     *
     * @param string $eventName
     * @param callable $listener
     * @return static $this for chaining
     */
    function off($eventName = null, callable $listener = null);

    /**
     * Dispatch an event.
     *
     * The event is dispatched to several event listeners if registered:
     * * The listener of the '*' event of the page
     * * The listener of the get_class($event) event of the page
     * * The listener of the '*' event of the widget
     * * The listener of the get_class($event) event of the widget
     *
     *
     * @param WidgetEvent $event
     * @param string $eventName Defaults to the class name of the supplied WidgetEvent
     */
    function dispatch(WidgetEvent $event, $eventName = null);

    /**
     * Access the bag (key/value store) assigned with this widget.
     * The bag can contain any (serializable) data that has no client side representation
     *  and must survive successive page calls.
     *
     * Warning: Do not store closures in the bag as they are not serializable!
     *
     * @return \ArrayObject
     */
    function getBag();

    /**
     * Apply several properties at once by supplying name/value pairs.
     *
     * @param string ...$args Pairs of property names and values
     * @return static $this for chaining
     */
    function apply($arg1 = null, $arg2 = null);
}
