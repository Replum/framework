<?php

namespace nexxes\widgets;

/**
 * Base interface for all widgets
 */
interface WidgetInterface {
	/**
	 * Check if the selected widget is the topmost widget aka the page
	 * 
	 * @return boolean
	 */
	function isRoot();
	
	/**
	 * Get the parent of this widget, used to navigate to the top of the widget tree.
	 * 
	 * @return \nexxes\widgets\WidgetInterface
	 */
	function getParent();
	
	/**
	 * Set the current parent widget for the current widget.
	 * Should not called directly to avoid creating corrupt widget hierarchies.
	 * Instead this method should be called from a container when a widget is added to that container.
	 * 
	 * @param \nexxes\widgets\WidgetInterface
	 * @return \nexxes\widgets\WidgetInterface $this for chaining
	 */
	function setParent(WidgetInterface $newParent);
	
	/**
	 * Return the complete list of ancestors of this widget up to the root element.
	 * The first element is the parent and the last element is the root.
	 * If $filterByType is supplied, only elements that are an instance of this type are returned.
	 * 
	 * @param string $filterByType
	 * @return array<\nexxes\widgets\WidgetInterface>
	 */
	function getAncestors($filterByType = null);
	
	/**
	 * Return the list of all widgets below this widget in the tree.
	 * The returned list is not ordnered in a specific way.
	 * If $filterByType is supplied, only elements that are an instance of this type are returned.
	 * 
	 * @param string $filterByType
	 * @return array<\nexxes\widgets\WidgetInterface>
	 */
	function getDescendants($filterByType = null);
	
	
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
	 * @return \nexxes\widgets\WidgetInterface $this for chaining
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
	 * Set the identifier for the widget and (re-)register the widget with the page widget registry.
	 * 
	 * If no $newID parameter it set, a new random ID is generated.
	 * 
	 * The ID may be set to custom name which avoids autogenerated identifiers for widgets that should hold the same id thru several instantiations of the same page.
	 * This allows parameters for that widgets to work when the page is restored from bookmarks, etc.
	 * 
	 * If the identifier is already used an exception is thrown.
	 * 
	 * @param string
	 * @throws \InvalidArgumentException
	 * @link http://www.w3.org/TR/html5/dom.html#the-id-attribute
	 */
	function setID($newID = null);
	
	
	/**
	 * Add the class to the list of classes if not already contained.
	 * 
	 * @param string $class Class to add
	 * @return \nexxes\widgets\WidgetInterface $this for chaining
	 * @link http://www.w3.org/TR/html5/dom.html#classes
	 */
	function addClass($class);
	
	/**
	 * Remove the supplied class if it exists in the list of classes.
	 * If the class was not previously set, no error is raised.
	 * 
	 * @param string $class The class name or regex to remove by
	 * @param boolean $isRegex Indicates if $class specifies the literal class name or a (perl compatible) regex to match classes against
	 * @return \nexxes\widgets\WidgetInterface $this for chaining
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
	 * @return \nexxes\widgets\WidgetInterface $this for chaining
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
	 * @return \nexxes\widgets\WidgetInterface $this for chaining
	 * @link http://www.w3.org/TR/html5/dom.html#attr-title
	 */
	function setTitle($newTitle);
}
