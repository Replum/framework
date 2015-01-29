<?php

namespace nexxes\widgets;

use \nexxes\widgets\events\WidgetEvent;

/**
 * Base interface for all widgets
 */
interface WidgetInterface
{

    /**
     * Check if the selected widget is the topmost widget aka the page
     *
     * @return boolean
     */
    function isRoot();

    /**
     * Get the parent of this widget, used to navigate to the top of the widget tree.
     *
     * @return self
     */
    function getParent();

    /**
     * Set the current parent widget for the current widget.
     * Should not called directly to avoid creating corrupt widget hierarchies.
     * Instead this method should be called from a container when a widget is added to that container.
     *
     * @param self
     * @return static $this for chaining
     */
    function setParent(WidgetInterface $newParent);

    /**
     * Unset the parent, used to trigger WidgetRemoveEvent handler
     *
     * @return static $this for chaining
     */
    function clearParent();

    /**
     * Return the complete list of ancestors of this widget up to the root element.
     * The first element is the parent and the last element is the root.
     * If $filterByType is supplied, only elements that are an instance of this type are returned.
     *
     * @param string $filterByType
     * @return array<self>
     */
    function getAncestors($filterByType = null);

    /**
     * Get the nearest anchestor of the supplied type
     *
     * @param string $type
     * @return null|object
     */
    function getNearestAncestor($type);

    /**
     * Return the list of all widgets below this widget in the tree.
     * The returned list is not ordnered in a specific way.
     * If $filterByType is supplied, only elements that are an instance of this type are returned.
     *
     * @param string $filterByType
     * @return array<self>
     */
    function getDescendants($filterByType = null);

    /**
     * Search the widget tree for a widget with the supplied ID.
     *
     * @param string $id
     * @return self|null
     */
    function findById($id);

    /**
     * Get the page this widget belongs to
     *
     * @return \nexxes\widgets\PageInterface
     */
    function getPage();

    /**
     * Check if the widget is marked as changed
     *
     * @return boolean
     */
    function isChanged();

    /**
     * Set/unset the changed status of the widget
     *
     * @param boolean
     * @return static $this for chaining
     */
    function setChanged($changed = true);

    /**
     * Render the HTML representation of the widget and return it as a string
     *
     * @return string The HTML code of the widget
     */
    function __toString();

    /**
     * Every widget can have an ID.
     * The ID is required to directly access/modify the widget in a subsequent JSON call.
     * If the element has no ID and is modified, the nearest ancestor with an ID must be
     * completely rerendered.
     *
     * An ID is generated upon the first access to the ID (getID) or explicitly using the
     * setID() method. Before an ID can be generated, a parent (with a path to the page)
     * must be set.
     *
     * @return boolean
     * @link http://www.w3.org/TR/html5/dom.html#the-id-attribute
     */
    function hasID();

    /**
     * Get the identifier of the widget.
     * The identifier is unique for all widgets within a page.
     *
     * @return string
     * @link http://www.w3.org/TR/html5/dom.html#the-id-attribute
     */
    function getID();

    /**
     * Set the identifier for the widget.
     * If the identifier is already used, false is returned.
     *
     * @param string
     * @return boolean
     * @link http://www.w3.org/TR/html5/dom.html#the-id-attribute
     */
    function setID($newID);

    /**
     * Indicate this widget needs an ID, defer the ID creation until widget is connected to the page.
     *
     * @return static $this for chaining
     */
    function needID();

    /**
     * Add the class to the list of classes if not already contained.
     *
     * @param string $class Class to add
     * @return static $this for chaining
     * @link http://www.w3.org/TR/html5/dom.html#classes
     */
    function addClass($class);

    /**
     * Remove the supplied class if it exists in the list of classes.
     * If the class was not previously set, no error is raised.
     *
     * @param string $class The class name or regex to remove by
     * @param boolean $isRegex Indicates if $class specifies the literal class name or a (perl compatible) regex to match classes against
     * @return static $this for chaining
     * @link http://www.w3.org/TR/html5/dom.html#classes
     */
    function delClass($class, $isRegex = false);

    /**
     * Checks if the supplied class is set for this widget
     *
     * @param string $class The class name or regex to check against
     * @param boolean $isRegex Indicates if $removeClass specifies the literal class name or a (perl compatible) regex to match classes against
     * @return boolean
     * @link http://www.w3.org/TR/html5/dom.html#classes
     */
    function hasClass($class, $isRegex = false);

    /**
     * Get the list of classes set
     *
     * @param string $regex The regex to filter awailable classes with.
     * @return array<string>
     * @link http://www.w3.org/TR/html5/dom.html#classes
     */
    function getClasses($regex = null);

    /**
     * Get the tabindex attribute.
     *
     * @return int
     * @link http://www.w3.org/TR/html5/editing.html#attr-tabindex
     */
    function getTabIndex();

    /**
     * Set the tabindex attribute.
     *
     * @param int $newTabIndex
     * @return static $this for chaining
     * @link http://www.w3.org/TR/html5/editing.html#attr-tabindex
     */
    function setTabIndex($newTabIndex);

    /**
     * Get the title attribute of the element
     *
     * @return string
     * @link http://www.w3.org/TR/html5/dom.html#attr-title
     */
    function getTitle();

    /**
     * Set the title attribute of this element
     *
     * @param string $newTitle
     * @return static $this for chaining
     * @link http://www.w3.org/TR/html5/dom.html#attr-title
     */
    function setTitle($newTitle);

    /**
     * Get the ARIA role of the element if defined.
     *
     * @return string
     * @link http://www.w3.org/TR/html5/dom.html#aria-role-attribute
     * @link http://www.w3.org/TR/wai-aria/roles
     */
    function getRole();

    /**
     * Set the ARIA role of the element.
     *
     * @param string $newRole
     * @return static $this for chaining
     * @link http://www.w3.org/TR/html5/dom.html#aria-role-attribute
     * @link http://www.w3.org/TR/wai-aria/roles
     */
    function setRole($newRole);

    /**
     * Get the data attribute for the supplied name or all data attributes set for the object.
     *
     * @param string $name
     * @return array<string>|string
     * @link http://www.w3.org/TR/html5/dom.html#embedding-custom-non-visible-data-with-the-data-*-attributes
     */
    function getData($name = null);

    /**
     * Append the supplied value to the data value.
     * If the value was empty, equal to setData.
     * Otherwise the $additionalValue is appended with a single space to separate it from previous values.
     *
     * @param string $name
     * @param string $additionalValue
     * @return static $this for chaining
     * @link http://www.w3.org/TR/html5/dom.html#embedding-custom-non-visible-data-with-the-data-*-attributes
     */
    function addData($name, $additionalValue);

    /**
     * Set a data attribute for the widget.
     *
     * @param string $name
     * @param string $newValue
     * @return static $this for chaining
     * @link http://www.w3.org/TR/html5/dom.html#embedding-custom-non-visible-data-with-the-data-*-attributes
     */
    function setData($name, $newValue);

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
