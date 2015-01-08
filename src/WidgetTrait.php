<?php

namespace nexxes\widgets;

use \nexxes\widgets\events\EventHandlerCallOnceWrapper;
use \nexxes\widgets\events\WidgetEvent;
use \nexxes\widgets\events\WidgetAddEvent;
use \nexxes\widgets\events\WidgetChangeEvent;
use \nexxes\widgets\events\WidgetRemoveEvent;

use \Symfony\Component\EventDispatcher\EventDispatcherInterface;
use \Symfony\Component\EventDispatcher\EventDispatcher;

/**
 * @property-read array<WidgetInterface> $ancestors Get all widgets above this widgets in the widget tree
 * @property-read array<WidgetInterface> $descendants Get all widgets below this widget in the widget tree
 * @property WidgetInterface $parent Widget directly above this widget
 * @property string $id Page wide unique identifier
 * @property string $role HTML role of this element on the page
 * @property string $title HTML title attribute
 * @property boolean $changed
 */
trait WidgetTrait {
	public function __construct(WidgetInterface $parent = null) {
		if (!is_null($parent)) { $this->setParent($parent); }
	}
	
	public function __get($propertyName) {
		if (\method_exists($this, 'get' . \ucfirst($propertyName))) {
			return $this->{'get' . \ucfirst($propertyName)}();
		}
		
		if (\method_exists($this, 'is' . \ucfirst($propertyName))) {
			return $this->{'is' . \ucfirst($propertyName)}();
		}
		
		if (\method_exists($this, 'has' . \ucfirst($propertyName))) {
			return $this->{'has' . \ucfirst($propertyName)}();
		}
		
		throw new \InvalidArgumentException('Access to unknown property "' . $propertyName . '"');
	}
	
	public function __set($propertyName, $value) {
		if (\method_exists($this, 'set' . \ucfirst($propertyName))) {
			$this->{'set' . \ucfirst($propertyName)}($value);
		}
		
		elseif (($value === true) && \method_exists($this, 'enable' . \ucfirst($propertyName))) {
			$this->{'enable' . \ucfirst($propertyName)}();
		}
		
		elseif (($value === false) && \method_exists($this, 'disable' . \ucfirst($propertyName))) {
			$this->{'disable' . \ucfirst($propertyName)}();
		}
		
		else {
			throw new \InvalidArgumentException('Writing unknown property "' . $propertyName . '"');	
		}
		
		return $value;
	}
	
	public function __unset($propertyName) {
		if (\method_exists($this, 'unset' . \ucfirst($propertyName))) {
			return $this->{'unset' . \ucfirst($propertyName)}();
		}
		
		throw new \InvalidArgumentException('Unsetting unknown property "' . $propertyName . '"');	
	}
	
	
	/**
	 * @var \nexxes\widgets\WidgetInterface
	 */
	private $widgetTraitParent = null;
	
	/**
	 * @implements \nexxes\widgets\WidgetInterface
	 */
	public function isRoot() {
		return (($this instanceof PageInterface) || is_null($this->widgetTraitParent));
	}
	
	/**
	 * @implements \nexxes\widgets\WidgetInterface
	 */
	public function getParent() {
		if (is_null($this->widgetTraitParent)) {
			throw new \InvalidArgumentException('No parent exists for this widget!');
		}
		
		return $this->widgetTraitParent;
	}
	
	/**
	 * Get the nearest anchestor of the supplied type
	 * 
	 * @param string $type
	 * @return null|object
	 */
	public function getNearestAncestor($type) {
		foreach ($this->getAncestors($type) as $ancestor) {
			return $ancestor;
		}
		
		return null;
	}
	
	/**
	 * @implements \nexxes\widgets\WidgetInterface+
	 * @returns \Traversable<WidgetInterface>
	 */
	public function getAncestors($filterByType = null) {
		if ($this->isRoot()) { return; }
		
		if (is_null($filterByType) || ($this->getParent() instanceof $filterByType)) {
			yield $this->getParent();
		}
		
		foreach ($this->getParent()->getAncestors($filterByType) as $ancestor) {
			yield $ancestor;
		}
	}
	
	/**
	 * Get an unfiltered list of all direct children.
	 * Overwrite in composite widgets to reuse descendant filtering
	 * 
	 * @return \Traversable<WidgetInterface>
	 */
	protected function getUnfilteredChildren() {
		return [];	
	}
	
	/**
	 * @implements \nexxes\widgets\WidgetInterface
	 */
	public function getDescendants($filterByType = null) {
		$descendants = [];
		
		foreach ($this->getUnfilteredChildren() AS $child) {
			if (is_null($filterByType) || is_a($child, $filterByType, true)) {
				$descendants[] = $child;
			}
			
			$descendants = \array_merge($descendants, $child->getDescendants($filterByType));
		}
		
		return $descendants;
	}
	
	/**
	 * @implements \nexxes\widgets\WidgetInterface
	 */
	public function findById($id) {
		if ($this->hasID() && ($this->getID() === $id)) {
			return $this;
		}
		
		foreach ($this->getUnfilteredChildren() as $child) {
			if (null !== ($found = $child->findById($id))) {
				return $found;
			}
		}
		
		return null;
	}
	
	/**
	 * @implements \nexxes\widgets\WidgetInterface
	 */
	public function setParent(WidgetInterface $newParent) {
		// Avoid recursion
		if ($this->widgetTraitParent === $newParent) {
			return $this;
		}
		
		// Remove from old parent
		$this->clearParent();
		
		// Add to new parent
		$this->widgetTraitParent = $newParent;
		$this->setChanged(true);
		
		// Add to parent if it is a widget container (not for composites!)
		if (($newParent instanceof WidgetContainerInterface) && (!$newParent->children()->contains($this))) {
			$newParent->children()[] = $this;
		}
		
		$this->getParent()->dispatch(new WidgetAddEvent($this->getParent(), $this));
		
		return $this;
	}
	
	public function clearParent() {
		// Prevent recursion
		if ($this->widgetTraitParent === null) {
			return $this;
		}
		
		$oldParent = $this->widgetTraitParent;
		$this->widgetTraitParent = null;
		
		if (($oldParent instanceof WidgetContainerInterface) && ($oldParent->children()->contains($this))) {
			$oldParent->children()->remove($this);
		}
		
		$oldParent->dispatch(new WidgetRemoveEvent($oldParent, $this));
		$this->setChanged();
		
		return $this;
	}
	
	
	
	
	/**
	 * @var \nexxes\widgets\PageInterface
	 */
	private $widgetTraitPage = null;
	
	/**
	 * @implements \nexxes\widgets\WidgetInterface
	 */
	public function getPage() {
		if (!is_null($this->widgetTraitPage)) {
			return $this->widgetTraitPage;
		}
		
		if ($this instanceof PageInterface) {
			$this->widgetTraitPage = $this;
		} elseif ($this->isRoot()) {
			return null;
		} elseif ($this->getParent() instanceof PageInterface) {
			$this->widgetTraitPage = $this->getParent();
		} else {
			$this->widgetTraitPage = $this->getParent()->getPage();
		}
		
		return $this->widgetTraitPage;
	}
	
	/**
	 * @implements \nexxes\widgets\WidgetInterface
	 */
	public function getRoot() {
		if ($this->isRoot()) {
			return $this;
		} else {
			return $this->getParent()->getRoot();
		}
	}
	
	
	
	
	/**
	 * @var boolean
	 */
	private $widgetTraitChanged = true;
	
	/**
	 * @implements \nexxes\widgets\WidgetInterface
	 */
	public function isChanged() {
		return $this->widgetTraitChanged;
	}
	
	/**
	 * @implements \nexxes\widgets\WidgetInterface
	 */
	public function setChanged($changed = true) {
		// Nothing new here
		if ($changed === $this->widgetTraitChanged) {
			return $this;
		}
		
		$this->widgetTraitChanged = $changed;
		$this->dispatch(new WidgetChangeEvent($this));
		
		return $this;
	}
	
	/**
	 * On restoring the widget on a successive call, mark it as unchanged
	 */
	public function __wakeup() {
		$this->widgetTraitChanged = false;
	}
	
	
	
	
	/**
	 * The page unique identifier for this widget
	 * 
	 * @var string
	 */
	private $widgetTraitId;
	
	/**
	 * {@inheritdoc}
	 * @implements \nexxes\widgets\WidgetInterface
	 */
	public function hasID() {
		return ($this->widgetTraitId !== null);
	}
	
	/**
	 * {@inheritdoc}
	 * @implements \nexxes\widgets\WidgetInterface
	 */
	public function getID() {
		if (!$this->hasID()) {
			$this->setID();
		}
		return $this->widgetTraitId;
	}
	
	/**
	 * {@inheritdoc}
	 * @implements \nexxes\widgets\WidgetInterface
	 */
	public function setID($newID = null, $skipNotify = false) {
		// Do not recalculate IDs
		if (($newID === null) && $this->hasID()) {
			return $this;
		}
		
		$oldID = $this->widgetTraitId;
		$this->widgetTraitId = $newID;
		
		// Prevent recursion
		if ($skipNotify || (($newID !== null) && ($oldID === $newID))) {
			return $this;
		}
		
		if ($this->getPage() === null) {
			throw new \RuntimeException('Can not set ID without page.');
		}
		
		/* @var $registry WidgetRegistry */
		$registry = $this->getPage()->getWidgetRegistry();
		$registry->register($this);
		
		$this->setChanged(true);
		
		return $this;
	}
	
	private $widgetTraitNeedId = false;
	
	/**
	 * @return static $this for chaining
	 * @see \nexxes\widgets\WidgetInterface::needID()
	 * @implements \nexxes\widgets\WidgetInterface
	 */
	public function needID() {
		$this->widgetTraitNeedId = true;
		return $this;
	}
	
	
	
	
	/**
	 * The list of classes this html widgets has
	 * 
	 * @var array<string>
	 * @see http://www.w3.org/TR/html5/dom.html#classes
	 */
	private $widgetTraitClasses = [];
	
	/**
	 *  @implements \nexxes\widgets\WidgetInterface
	 */
	public function addClass($newClass) {
		if (!\in_array($newClass, $this->widgetTraitClasses, true)) {
			$this->widgetTraitClasses[] = $newClass;
			$this->setChanged(true);
		}
		
		return $this;
	}
	
	/**
	 * @implements \nexxes\widgets\WidgetInterface
	 */
	public function delClass($class, $isRegex = false) {
		// Regex matching
		if ($isRegex) {
			foreach ($this->widgetTraitClasses AS $index => $checkClass) {
				if (\preg_match($class, $checkClass)) {
					unset($this->widgetTraitClasses[$index]);
					$this->setChanged(true);
				}
			}
		}
		
		// Literal class name matching
		elseif (($key = \array_search($class, $this->widgetTraitClasses)) !== false) {
			unset($this->widgetTraitClasses[$key]);
			$this->setChanged(true);
		}
		
		return $this;
	}
	
	/**
	 * @implements \nexxes\widgets\WidgetInterface
	 */
	public function hasClass($class, $isRegex = false) {
		// Regex matching
		if ($isRegex) {
			foreach ($this->widgetTraitClasses AS $checkClass) {
				if (\preg_match($class, $checkClass)) {
					return true;
				}
			}
			
			return false;
		}
		
		// Literal class name matching
		else {
			return \in_array($class, $this->widgetTraitClasses);
		}
	}
	
	/**
	 * @implements \nexxes\widgets\WidgetInterface
	 */
	public function getClasses($regex = null) {
		\sort($this->widgetTraitClasses);
		
		// Get only classes matching the supplied regex
		if (!is_null($regex)) {
			$found = [];
			foreach ($this->widgetTraitClasses AS $class) {
				if (\preg_match($regex, $class)) {
					$found[] = $class;
				}
			}
			return $found;
		}
		
		// Get all classes
		else {
			return $this->widgetTraitClasses;
		}
	}
	
	
	
	
	/**
	 * The tabindex content attribute allows authors to control whether an element is supposed to be focusable, whether it is supposed to be reachable using sequential focus navigation, and what is to be the relative order of the element for the purposes of sequential focus navigation. The name "tab index" comes from the common use of the "tab" key to navigate through the focusable elements. The term "tabbing" refers to moving forward through the focusable elements that can be reached using sequential focus navigation.
	 * 
	 * @var int
	 * @see http://www.w3.org/TR/html5/editing.html#attr-tabindex
	 */
	private $widgetTraitTabindex;
	
	/**
	 * @implements \nexxes\widgets\WidgetInterface
	 */
	public function getTabIndex() {
		return $this->widgetTraitTabindex;
	}
	
	/**
	 * @implements \nexxes\widgets\WidgetInterface
	 */
	public function setTabIndex($newTabIndex) {
		if (!\is_null($newTabIndex) && !\is_int($newTabIndex)) {
			if (preg_match('/^(0|-?[1-9][0-9]*)$/', $newTabIndex)) {
				$newTabIndex = (int)$newTabIndex;
			} else {
				throw new \InvalidArgumentException('TabIndex can only be set to an integer value!');
			}
		}
		
		if ($this->widgetTraitTabindex !== $newTabIndex) {
			$this->widgetTraitTabindex = $newTabIndex;
			$this->setChanged(true);
		}
		
		return $this;
	}
	
	
	
	
	/**
	 * The title attribute represents advisory information for the element, such as would be appropriate for a tooltip. On a link, this could be the title or a description of the target resource; on an image, it could be the image credit or a description of the image; on a paragraph, it could be a footnote or commentary on the text; on a citation, it could be further information about the source; on interactive content, it could be a label for, or instructions for, use of the element; and so forth. The value is text.
	 * 
	 * @var string
	 * @see http://www.w3.org/TR/html5/dom.html#attr-title
	 */
	private $widgetTraitTitle;
	
	/**
	 * @implements \nexxes\widgets\WidgetInterface
	 */
	public function getTitle() {
		return $this->widgetTraitTitle;
	}
	
	/**
	 * @param string $newTitle
	 * @return static $this for chaining
	 * 
	 * @see \nexxes\widgets\WidgetInterface::setTitle()
	 */
	public function setTitle($newTitle) {
		return $this->setStringProperty('title', $newTitle);
	}
	
	
	
	
	/**
	 * Roles are defined and described by their characteristics. Characteristics define the structural function of a role, such as what a role is, concepts behind it, and what instances the role can or must contain. In the case of widgets this also includes how it interacts with the user agent based on mapping to HTML forms and XForms. States and properties from WAI-ARIA that are supported by the role are also indicated.
	 * 
	 * @var string
	 * @link http://www.w3.org/TR/html5/dom.html#aria-role-attribute
	 * @link http://www.w3.org/TR/wai-aria/roles
	 */
	private $widgetTraitRole;
	
	/**
	 * @implements \nexxes\widgets\WidgetInterface
	 */
	public function getRole() {
		return $this->widgetTraitRole;
	}
	
	/**
	 * @param string $newRole
	 * @return static $this for chaining
	 * 
	 * @see \nexxes\widgets\WidgetInterface::setRole()
	 */
	public function setRole($newRole) {
		if (!\in_array($newRole, $this->validRoles())) {
			throw new \InvalidArgumentException('Invalid role value!');
		}
		
		return $this->setStringProperty('role', $newRole);
	}
	
	/**
	 * List of available roles.
	 * Overwrite method to limit roles for this element.
	 * 
	 * @link http://www.w3.org/TR/wai-aria/appendices#quickref
	 */
	protected function validRoles() {
		return [
			'alert', 'alertdialog', 'application', 'article', 'banner',
			'button', 'checkbox', 'columnheader', 'combobox', 'complementary',
			'contentinfo', 'definition', 'dialog', 'directory', 'document',
			'form', 'grid', 'gridcell', 'group', 'heading',
			'img', 'link', 'list', 'listbox', 'listitem',
			'log', 'main', 'marquee', 'math', 'menu',
			'menubar', 'menuitem', 'menuitemcheckbox', 'menuitemradio', 'navigation',
			'note', 'option', 'presentation', 'progressbar', 'radio',
			'radiogroup', 'region', 'row', 'rowgroup', 'rowheader',
			'search', 'separator', 'scrollbar', 'slider', 'spinbutton',
			'status', 'tab', 'tablist', 'tabpanel', 'textbox',
			'timer', 'toolbar', 'tooltip', 'tree', 'treegrid',
			'treeitem',
		];
	}
	
	
	
	
	/**
	 * Custom data attributes
	 * 
	 * @var array<string>
	 * @link http://www.w3.org/TR/html5/dom.html#embedding-custom-non-visible-data-with-the-data-*-attributes
	 */
	private $widgetTraitData = [];
	
	public function addData($name, $value) {
		$oldValue = $this->getData($name);
		return $this->setData($name, ($oldValue ? $oldValue . ' ' . $value : $value));
	}
	
	/**
	 * @implements \nexxes\widgets\WidgetInterface
	 */
	public function getData($name = null) {
		if (is_null($name)) {
			return $this->widgetTraitData;
		}
		
		elseif (isset($this->widgetTraitData[$name])) {
			return $this->widgetTraitData[$name];
		}
		
		else {
			return null;
		}
	}
	
	/**
	 * @param string $name
	 * @param string $newValue
	 * @return static $this for chaining
	 * 
	 * @see \nexxes\widgets\WidgetInterface
	 */
	public function setData($name, $newValue) {
		if (\is_null($name) || !\is_string($name)) {
			throw new \InvalidArgumentException('Data attribute requires a name!');
		}
		
		if (\strpos($name, ':') !== false) {
			throw new \InvalidArgumentException('Data attribute name "' . $name . '" contains illegal character ":".');
		}
		
		if (\strtolower(\substr($name, 0, 3)) === 'xml') {
			throw new \InvalidArgumentException('Data attribute name "' . $name . '" must not start with "xml".');
		}
		
		if (!$this->validateAttributeName($name)) {
			throw new \InvalidArgumentException('Invalid data attribute name "' . $name . '".');
		}
		
		if (\preg_match('/-[a-z]/', $name)) {
			throw new \InvalidArgumentException('Data attribute name "' . $name . '" must not contain a "-" followed by a lowercase character.');
		}
		
		if (\is_null($newValue)) {
			if (isset($this->widgetTraitData[$name])) {
				unset($this->widgetTraitData[$name]);
				$this->setChanged(true);
			}
		}
		
		elseif (!\is_string($newValue)) {
			throw new \InvalidArgumentException('Can not set data attribute "' . $name . '" to a non-string value.');
		}
		
		elseif (!isset($this->widgetTraitData[$name]) || ($this->widgetTraitData[$name] !== $newValue)) {
			$this->widgetTraitData[$name] = $newValue;
			$this->setChanged(true);
		}
		
		return $this;
	}
	
	protected function renderDataAttributes() {
		$r = '';
		
		foreach ($this->widgetTraitData as $dataName => $dataValue) {
			$dataName = \preg_replace_callback('/[A-Z]/', function($matches) { return '-' . \strtolower($matches[0]); }, $dataName);
			$r .= ' data-' . $dataName . '="' . $this->escape($dataValue) . '"';
		}
		
		return $r;
	}
	
	/**
	 * Verify the supplied name is a valid xml attribute name
	 * 
	 * @param string $name
	 * @return boolean
	 * @link http://www.w3.org/TR/xml/#NT-Name
	 */
	protected function validateAttributeName($name) {
		$nameStartChar = ':|[A-Z]|_|[a-z]|[\xC0-\xD6]|[\xD8-\xF6]|[\xF8-\x{2FF}]|[\x{370}-\x{37D}]|[\x{37F}-\x{1FFF}]|[\x{200C}-\x{200D}]|[\x{2070}-\x{218F}]|[\x{2C00}-\x{2FEF}]|[\x{3001}-\x{D7FF}]|[\x{F900}-\x{FDCF}]|[\x{FDF0}-\x{FFFD}]';
		// |[\x{10000}-\x{EFFFF}] must be appended according to the ref but is invalid in PHP/PCRE
		$nameChar = $nameStartChar . '|-|.|[0-9]|\xB7|[\x{0300}-\x{036F}]|[\x{203F}-\x{2040}]';
		
		return \preg_match('/^(' . $nameStartChar . ')(' . $nameChar . ')*$/u', $name);
	}
	
	
	
	
	/**
	 * Render all common Widget attributes
	 * 
	 * @return string
	 * @codeCoverageIgnore
	 */
	protected function renderWidgetAttributes() {
		\sort($this->widgetTraitClasses);
		
		if (($this->eventDispatcher !== null) || $this->widgetTraitNeedId) {
			$this->getID();
		}
		
		return $this->renderHtmlAttribute('id', $this->widgetTraitId)
			. $this->renderHtmlAttribute('class', $this->widgetTraitClasses)
			. $this->renderDataAttributes()
			. $this->renderHtmlAttribute('role', $this->widgetTraitRole)
			.	$this->renderHtmlAttribute('title', $this->widgetTraitTitle)
			. $this->renderHtmlAttribute('tabindex', $this->widgetTraitTabindex)
		;
	}
	
	/**
	 * Render all attributes of the current widget.
	 * Default implementation, override in concrete implementations.
	 * Include renderWidgetAttributes() instead of renaming renderAttributes() when using the trait.
	 * 
	 * @return string
	 */
	protected function renderAttributes() {
		return $this->renderWidgetAttributes();
	}
	
	
	
	
	/**
	 * Make the supplied data safe to use it in an HTML document
	 * 
	 * @param string $string
	 * @return string
	 * @codeCoverageIgnore
	 */
	protected function escape($string) {
		return \htmlspecialchars($string, ENT_HTML5|ENT_COMPAT, 'UTF-8');
	}
	
	######################################################################
	#
	# Event handling
	#
	######################################################################
	
	/**
	 * @var EventDispatcherInterface
	 */
	private $eventDispatcher;
	
	/**
	 * @return static $this for chaining
	 * @implements WidgetInterface
	 * @see WidgetInterface::on() WidgetInterface::on()
	 */
	public function on($eventName, callable $listener, $priority = 50) {
		if (is_null($this->eventDispatcher)) {
			$this->eventDispatcher = new EventDispatcher();
		}
		
		$this->eventDispatcher->addListener($eventName, $listener, $priority);
		return $this;
	}
	
	/**
	 * @return static $this for chaining
	 * @implements WidgetInterface
	 * @see WidgetInterface::one() WidgetInterface::one()
	 */
	public function one($eventName, callable $listener, $priority = 50) {
		return $this->on($eventName, new EventHandlerCallOnceWrapper($listener), $priority);
	}
	
	/**
	 * @return static $this for chaining
	 * @implements WidgetInterface
	 * @see WidgetInterface::off() WidgetInterface::off()
	 */
	public function off($eventName = null, callable $listener = null) {
		if (is_null($this->eventDispatcher)) {
			return $this;
		}
		
		// Cleanup all handlers
		if (($this->eventName === null) && ($this->listener === null)) {
			$this->eventDispatcher = null;
		}
		
		elseif ($this->eventName === null) {
			foreach ($this->eventDispatcher->getListeners() as $eventName => $listeners) {
				$this->removeListenerIfExists($eventName, $listeners, $listener);
			}
		}
		
		else {
			$this->removeListenerIfExists($eventName, $this->eventDispatcher->getListeners($eventName), $listener);
		}
		
		return $this;
	}
	
	/**
	 * Helper function to remove all listeners for a specific event.
	 * 
	 * @param string $eventName
	 * @param array $listeners List of available listeners
	 * @param callable $listener
	 */
	private function removeListenerIfExists($eventName, $listeners, $listener) {
		foreach ($listeners as $existingListener) {
			if (
				($listener === null)
				|| ($existingListener === $listener)
				|| (($existingListener instanceof EventHandlerCallOnceWrapper) && ($existingListener->wraps($listener)))
			) {
				$this->eventDispatcher->removeListener($eventName, $listener);
			}
		}
	}
	
	/**
	 * @implements WidgetInterface
	 * @see WidgetInterface::dispatch() WidgetInterface::dispatch()
	 */
	public function dispatch(WidgetEvent $event, $eventName = null) {
		if ($eventName === null) {
			$eventName = \get_class($event);
		}
		
		if (!$this->isRoot() && ($this->getPage() !== null)) {
			if (!$event->isPropagationStopped()) { $this->getPage()->dispatch($event, '*'); }
			if (!$event->isPropagationStopped()) { $this->getPage()->dispatch($event); }
		}
		
		if ($this->eventDispatcher !== null) {
			if (!$event->isPropagationStopped()) { $this->eventDispatcher->dispatch('*', $event); }
			if (!$event->isPropagationStopped()) { $this->eventDispatcher->dispatch($eventName, $event); }
		}
		
		return $this;
	}
	
	######################################################################
	#
	# Bag key/value store
	#
	######################################################################
	
	/**
	 * @var \ArrayObject
	 */
	private $bag;
	
	/**
	 * @implements WidgetInterface::getBag()
	 * @see WidgetInterface::getBag() WidgetInterface::getBag()
	 */
	public function getBag() {
		if (!isset($this->bag)) {
			$this->bag = new \ArrayObject();
		}
		return $this->bag;
	}
	
	/**
	 * Detault factory method to create a new instance
	 * 
	 * @param WidgetInterface $parent The new parent
	 * @param mixed ...$args Pairs of property names and values to apply to the new instance
	 * @return static New instance
	 */
	public static function create(WidgetInterface $parent = null) {
		$widget = new static($parent);
		$widget->applyArguments(1, \func_get_args());
		return $widget;
	}
	
	/**
	 * @param string ...$args Pairs of property names and values
	 * @return static $this for chaining
	 * @throws \InvalidArgumentException
	 */
	public function apply($arg1 = null, $arg2 = null) {
		return $this->applyArguments(0, \func_get_args());
	}
	
	/**
	 * Read value pairs from the list of arguments and treat them as property name and property value.
	 * Ignore the first $stripArgs as they may contain e.g. constructor specific parameters.
	 * 
	 * @param integer $stripArgs
	 * @param array $args
	 * @return static $this for chaining
	 */
	protected function applyArguments($stripArgs, array $args) {
		if ((\count($args)-$stripArgs) % 2) {
			throw new \InvalidArgumentException('Require pairs of attribute names and values!');
		}
		
		for ($i=$stripArgs; $i<\count($args); $i+=2) {
			$propertyName = $args[$i];
			$propertyValue = $args[$i+1];

			if ($propertyName === 'class') {
				$this->addClass($propertyValue);
			}

			elseif (\substr($propertyName, 0, 4) === 'data') {
				$this->setData(\lcfirst(\substr($propertyName, 4)), $propertyValue);
			}

			else {
				// Force setter method to be called
				$this->__set($propertyName,  $propertyValue);
			}
		}
		
		return $this;
	}
	
	
	
	
	######################################################################
	#
	# Helper methods to set values
	#
	######################################################################
	
	/**
	 * @param string $property
	 * @param mixed $value
	 * @return static $this for chaining
	 */
	protected function setStringProperty($property, $value) {
		if (\is_scalar($value) || (\is_object($value) && \method_exists($value, '__toString'))) {
			$realValue = (string)$value;
		} elseif (\is_null($value)) {
			$realValue = $value;
		}	else {
			throw new \InvalidArgumentException('Can not set property "' . $property . '" to something not convertable to a string.');
		}
		
		return $this->setPropertyValue($property, $realValue);
	}
	
	protected function setBooleanProperty($property, $value) {
		if (\is_bool($value)) {
			$realValue = $value;
		} elseif (\is_string($value) && \in_array(\strtolower($value), ['1', 'true', 'yes', 'on',])) {
			$realValue = true;
		} elseif (\is_string($value) && \in_array(\strtolower($value), ['0', 'false', 'no', 'off',])) {
			$realValue = true;
		} else {
			throw new \InvalidArgumentException('Can not set property "' . $property . '" to something not convertable to a boolean.');
		}
		
		return $this->setPropertyValue($property, $realValue);
	}
	
	protected function setPropertyValue($property, $value) {
		if ($this->$property !== $value) {
			$this->setChanged();
			$this->$property = $value;
		}
		
		return $this;
	}
	
	protected function renderHtmlAttribute($name, $value) {
		if (\is_null($value)) { return ''; }
		
		if (\is_array($value)) {
			$escaped = \array_reduce($value, function ($carry, $value) {
				return ($carry !== null ? $carry . ' ' : '') . $this->escape($value);
			});
		} else {
			$escaped = $this->escape($value);
		}
		
		return ' ' . $name . '="' . $escaped . '"';
	}
}
