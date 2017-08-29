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

    ######################################################################
    # Page handling                                                      #
    ######################################################################

    /**
     * Get the page this widget belongs to
     */
    function getPage() : PageInterface;

    ######################################################################
    # Hierarchy handling                                                 #
    ######################################################################

    /**
     * Check if the selected widget is the topmost widget aka the page
     */
    function isRoot() : bool;

    /**
     * Get the parent of this widget, used to navigate to the top of the widget tree.
     */
    function getParent() : self;

    /**
     * Whether the widget has a parent.
     * Root widgets and detached widgets have no parent.
     */
    function hasParent() : bool;

    /**
     * Set the current parent widget for the current widget.
     * Should not called directly to avoid creating corrupt widget hierarchies.
     * Instead this method should be called from a container when a widget is added to that container.
     *
     * @return static $this
     */
    function setParent(self $newParent) : self;

    /**
     * Unset the parent, used to trigger WidgetRemoveEvent handler
     *
     * @return static $this
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
     * @return null|self
     */
    function getNearestAncestor(string $type);

    /**
     * Check if the widget is marked as changed
     */
    function isChanged() : bool;

    /**
     * Set/unset the changed status of the widget
     *
     * @return static $this
     */
    function setChanged(bool $changed = true) : self;

    /**
     * Render the HTML representation of the widget and return it as a string
     *
     * @return string The HTML code of the widget
     */
    function render() : string;

    ######################################################################
    # Event handling                                                     #
    ######################################################################

    /**
     * Add an event handler to this widget.
     *
     * @param string $eventName
     * @param callable $listener
     * @param int $priority
     * @return static $this
     */
    function on(string $eventName, callable $listener, int $priority = 50) : self;

    /**
     * Add an event handler to this widget that is executed only once.
     *
     * @param string $eventName
     * @param callable $listener
     * @param int $priority
     * @return static $this
     */
    function one(string $eventName, callable $listener, int $priority = 50) : self;

    /**
     * Remove event handler(s) from the widget.
     * If $eventName and $listener are null, all event handlers are removed.
     * If only $listener is null, all handlers for event $eventName are removed.
     *
     * @param string $eventName
     * @param callable $listener
     * @return static $this
     */
    function off(string $eventName = null, callable $listener = null) : self;

    /**
     * Dispatch an event.
     *
     * The event is dispatched to several event listeners if registered:
     * * The listener of the get_class($event) event of the widget
     * * The listener of the '*' event of the widget
     * * The same for all anchestors
     *
     * @param WidgetEvent $event
     * @param string $eventName Defaults to the class name of the supplied WidgetEvent
     * @return static $this
     */
    function dispatch(WidgetEvent $event, string $eventName = null) : self;

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
}
