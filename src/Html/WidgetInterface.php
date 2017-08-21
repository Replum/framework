<?php

/*
 * This file is part of Replum: the web widget framework.
 *
 * Copyright (c) Dennis Birkholz <dennis@birkholz.org>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Replum\Html;

/**
 * Required global attributes for HTML elements
 *
 * @see https://www.w3.org/TR/html5/dom.html#global-attributes
 * @author Dennis Birkholz <dennis@birkholz.org>
 */
interface WidgetInterface extends \Replum\WidgetContainerInterface
{
    ######################################################################
    # Accesskey                                                          #
    ######################################################################

    ######################################################################
    # Class attribute                                                    #
    ######################################################################

    /**
     * Add the class to the list of classes if not already contained.
     *
     * @param string $class Class to add
     * @return $this
     * @link http://www.w3.org/TR/html5/dom.html#classes
     */
    function addClass(string $class) : self;

    /**
     * Remove the supplied class if it exists in the list of classes.
     * If the class was not previously set, no error is raised.
     *
     * @param string $class The class name or regex to remove by
     * @param boolean $isRegex Indicates if $class specifies the literal class name or a (perl compatible) regex to match classes against
     * @return $this
     * @link http://www.w3.org/TR/html5/dom.html#classes
     */
    function delClass(string $class, bool $isRegex = false) : self;

    /**
     * Checks if the supplied class is set for this widget
     *
     * @param string $class The class name or regex to check against
     * @param boolean $isRegex Indicates if $removeClass specifies the literal class name or a (perl compatible) regex to match classes against
     * @return boolean
     * @link http://www.w3.org/TR/html5/dom.html#classes
     */
    function hasClass(string $class, bool $isRegex = false) : bool;

    /**
     * Get the list of classes set
     *
     * @param string $regex The regex to filter awailable classes with.
     * @return array<string>
     * @link http://www.w3.org/TR/html5/dom.html#classes
     */
    function getClasses(bool $regex = null) : array;

    ######################################################################
    # Content Editable attribute                                         #
    ######################################################################

    ######################################################################
    # Dir attribute                                                      #
    ######################################################################

    ######################################################################
    # Hidden attribute                                                   #
    ######################################################################

    ######################################################################
    # ID attribute                                                       #
    ######################################################################

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
     * @link http://www.w3.org/TR/html5/dom.html#the-id-attribute
     */
    function hasID() : bool;

    /**
     * Get the identifier of the widget.
     * The identifier is unique for all widgets within a page.
     *
     * @link http://www.w3.org/TR/html5/dom.html#the-id-attribute
     */
    function getID() : string;

    /**
     * Set the identifier for the widget.
     * An exception is thrown if the ID is already in use.
     *
     * @return $this
     * @link http://www.w3.org/TR/html5/dom.html#the-id-attribute
     */
    function setID(string $newID) : self;

    /**
     * Let the widget generate an ID.
     *
     * @return $this
     */
    function needID() : self;

    ######################################################################
    # Lang attribute                                                     #
    ######################################################################

    ######################################################################
    # Spellcheck attribute                                               #
    ######################################################################

    ######################################################################
    # Style attribute                                                    #
    ######################################################################

    /**
     * Get the title attribute of the element
     *
     * @link http://www.w3.org/TR/html5/dom.html#attr-style
     */
    function getStyle() : string;

    /**
     * Check whether the title attribute is set
     * @link http://www.w3.org/TR/html5/dom.html#attr-style
     */
    function hasStyle() : bool;

    /**
     * Set the title attribute of this element
     *
     * @return $this
     * @link http://www.w3.org/TR/html5/dom.html#attr-style
     */
    function setStyle(string $newStyle) : self;

    ######################################################################
    # Tabindex attribute                                                 #
    ######################################################################

    /**
     * Check whether the tabindex attribute is set
     *
     * @link http://www.w3.org/TR/html5/editing.html#attr-tabindex
     */
    function hasTabIndex() : bool;

    /**
     * Get the tabindex attribute.
     *
     * @link http://www.w3.org/TR/html5/editing.html#attr-tabindex
     */
    function getTabIndex() : int;

    /**
     * Set the tabindex attribute, null to clear it
     *
     * @return $this
     * @link http://www.w3.org/TR/html5/editing.html#attr-tabindex
     */
    function setTabIndex(int $newTabIndex = null) : self;

    ######################################################################
    # Title attribute                                                    #
    ######################################################################

    /**
     * Get the title attribute of the element
     *
     * @link http://www.w3.org/TR/html5/dom.html#attr-title
     */
    function getTitle() : string;

    /**
     * Check whether the title attribute is set
     *
     * @link http://www.w3.org/TR/html5/dom.html#attr-title
     */
    function hasTitle() : bool;

    /**
     * Set the title attribute of this element
     *
     * @return $this
     * @link http://www.w3.org/TR/html5/dom.html#attr-title
     */
    function setTitle(string $newTitle) : self;

    ######################################################################
    # Translate attribute                                                #
    ######################################################################

    ######################################################################
    # Custom data attributes                                             #
    ######################################################################

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
    function addData(string $name, string $additionalValue) : self;

    /**
     * Get the data attribute for the supplied name
     *
     * @link http://www.w3.org/TR/html5/dom.html#embedding-custom-non-visible-data-with-the-data-*-attributes
     */
    function getData(string $name) : string;

    /**
     * Check whether a data attribute with the given name is set
     *
     * @link http://www.w3.org/TR/html5/dom.html#embedding-custom-non-visible-data-with-the-data-*-attributes
     */
    function hasData(string $name) : bool;

    /**
     * Get a key => value mapping of all defined data attributes
     *
     * @return array<string,string>
     */
    function getDataset() : array;

    /**
     * Set a data attribute for the widget, a null value will clear the attribute
     *
     * @return $this
     * @link http://www.w3.org/TR/html5/dom.html#embedding-custom-non-visible-data-with-the-data-*-attributes
     */
    function setData(string $name, string $newValue = null) : self;
}
