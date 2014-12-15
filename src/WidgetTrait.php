<?php

namespace nexxes\widgets;

use \nexxes\dependency\Container;
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
	private $WidgetTraitParent = null;
	
	/**
	 * @implements \nexxes\widgets\WidgetInterface
	 */
	public function isRoot() {
		return (($this instanceof PageInterface) || is_null($this->WidgetTraitParent));
	}
	
	/**
	 * @implements \nexxes\widgets\WidgetInterface
	 */
	public function getParent() {
		if (is_null($this->WidgetTraitParent)) {
			throw new \InvalidArgumentException('No parent exists for this widget!');
		}
		
		return $this->WidgetTraitParent;
	}
	
	/**
	 * @implements \nexxes\widgets\WidgetInterface
	 */
	public function getAncestors($filterByType = null) {
		if ($this->isRoot()) {
			return [];
		}
		
		$ancestors = $this->getParent()->getAncestors($filterByType);
		
		if (is_null($filterByType) || ($this->getParent() instanceof $filterByType)) {
			\array_unshift($ancestors, $this->getParent());
		}
		
		return $ancestors;
	}
	
	/**
	 * @implements \nexxes\widgets\WidgetInterface
	 */
	public function getDescendants($filterByType = null) {
		return [];
	}
	
	/**
	 * @implements \nexxes\widgets\WidgetInterface
	 */
	public function findById($id) {
		if ($this->hasID() && ($this->getID() === $id)) {
			return $this;
		}
		
		return null;
	}
	
	/**
	 * @implements \nexxes\widgets\WidgetInterface
	 */
	public function setParent(WidgetInterface $newParent) {
		// Avoid recursion
		if ($this->WidgetTraitParent === $newParent) {
			return $this;
		}
		
		// Remove from old parent
		$this->clearParent();
		
		// Add to new parent
		$this->WidgetTraitParent = $newParent;
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
		if ($this->WidgetTraitParent === null) {
			return $this;
		}
		
		if (($this->WidgetTraitParent instanceof WidgetContainerInterface) && ($this->WidgetTraitParent->children()->contains($this))) {
			$this->WidgetTraitParent->children()->remove($this);
		}
		
		$this->getParent()->dispatch(new WidgetRemoveEvent($this->getParent(), $this));
		
		$this->WidgetTraitParent = null;
		$this->setChanged();
		
		return $this;
	}
	
	
	
	
	/**
	 * @var \nexxes\widgets\PageInterface
	 */
	private $WidgetTraitPage = null;
	
	/**
	 * @implements \nexxes\widgets\WidgetInterface
	 */
	public function getPage() {
		if (!is_null($this->WidgetTraitPage)) {
			return $this->WidgetTraitPage;
		}
		
		if ($this instanceof PageInterface) {
			$this->WidgetTraitPage = $this;
		} elseif ($this->isRoot()) {
			return null;
		} elseif ($this->getParent() instanceof PageInterface) {
			$this->WidgetTraitPage = $this->getParent();
		} else {
			$this->WidgetTraitPage = $this->getParent()->getPage();
		}
		
		return $this->WidgetTraitPage;
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
	private $WidgetTraitChanged = true;
	
	/**
	 * @implements \nexxes\widgets\WidgetInterface
	 */
	public function isChanged() {
		return $this->WidgetTraitChanged;
	}
	
	/**
	 * @implements \nexxes\widgets\WidgetInterface
	 */
	public function setChanged($changed = true) {
		// Nothing new here
		if ($changed === $this->WidgetTraitChanged) {
			return $this;
		}
		
		$this->WidgetTraitChanged = $changed;
		$this->dispatch(new WidgetChangeEvent($this));
		
		return $this;
	}
	
	/**
	 * On restoring the widget on a successive call, mark it as unchanged
	 */
	public function __wakeup() {
		$this->WidgetTraitChanged = false;
	}
	
	
	
	
	/**
	 * The page unique identifier for this widget
	 * 
	 * @var string
	 */
	private $WidgetTraitId;
	
	/**
	 * {@inheritdoc}
	 * @implements \nexxes\widgets\WidgetInterface
	 */
	public function hasID() {
		return ($this->WidgetTraitId !== null);
	}
	
	/**
	 * {@inheritdoc}
	 * @implements \nexxes\widgets\WidgetInterface
	 */
	public function getID() {
		if (!$this->hasID()) {
			$this->setID();
		}
		return $this->WidgetTraitId;
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
		
		$oldID = $this->WidgetTraitId;
		$this->WidgetTraitId = $newID;
		
		// Prevent recursion
		if ($skipNotify || (($newID !== null) && ($oldID === $newID))) {
			return $this;
		}
		
		/* @var $registry WidgetRegistry */
		$registry = $this->getPage()->getWidgetRegistry();
		$registry->register($this);
		
		$this->setChanged(true);
		
		return $this;
	}
	
	
	
	
	/**
	 * The list of classes this html widgets has
	 * 
	 * @var array<string>
	 * @see http://www.w3.org/TR/html5/dom.html#classes
	 */
	private $WidgetTraitClasses = [];
	
	/**
	 *  @implements \nexxes\widgets\WidgetInterface
	 */
	public function addClass($newClass) {
		if (!\in_array($newClass, $this->WidgetTraitClasses, true)) {
			$this->WidgetTraitClasses[] = $newClass;
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
			foreach ($this->WidgetTraitClasses AS $index => $checkClass) {
				if (\preg_match($class, $checkClass)) {
					unset($this->WidgetTraitClasses[$index]);
					$this->setChanged(true);
				}
			}
		}
		
		// Literal class name matching
		elseif (($key = \array_search($class, $this->WidgetTraitClasses)) !== false) {
			unset($this->WidgetTraitClasses[$key]);
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
			foreach ($this->WidgetTraitClasses AS $checkClass) {
				if (\preg_match($class, $checkClass)) {
					return true;
				}
			}
			
			return false;
		}
		
		// Literal class name matching
		else {
			return \in_array($class, $this->WidgetTraitClasses);
		}
	}
	
	/**
	 * @implements \nexxes\widgets\WidgetInterface
	 */
	public function getClasses($regex = null) {
		\sort($this->WidgetTraitClasses);
		
		// Get only classes matching the supplied regex
		if (!is_null($regex)) {
			$found = [];
			foreach ($this->WidgetTraitClasses AS $class) {
				if (\preg_match($regex, $class)) {
					$found[] = $class;
				}
			}
			return $found;
		}
		
		// Get all classes
		else {
			return $this->WidgetTraitClasses;
		}
	}
	
	
	
	
	/**
	 * The tabindex content attribute allows authors to control whether an element is supposed to be focusable, whether it is supposed to be reachable using sequential focus navigation, and what is to be the relative order of the element for the purposes of sequential focus navigation. The name "tab index" comes from the common use of the "tab" key to navigate through the focusable elements. The term "tabbing" refers to moving forward through the focusable elements that can be reached using sequential focus navigation.
	 * 
	 * @var int
	 * @see http://www.w3.org/TR/html5/editing.html#attr-tabindex
	 */
	private $WidgetTraitTabindex;
	
	/**
	 * @implements \nexxes\widgets\WidgetInterface
	 */
	public function getTabIndex() {
		return $this->WidgetTraitTabindex;
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
		
		if ($this->WidgetTraitTabindex !== $newTabIndex) {
			$this->WidgetTraitTabindex = $newTabIndex;
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
	private $WidgetTraitTitle;
	
	/**
	 * @implements \nexxes\widgets\WidgetInterface
	 */
	public function getTitle() {
		return $this->WidgetTraitTitle;
	}
	
	/**
	 * @implements \nexxes\widgets\WidgetInterface
	 */
	public function setTitle($newTitle) {
		if (!\is_null($newTitle) && !\is_string($newTitle)) {
			throw new \InvalidArgumentException('Title can only be set to a string value!');
		}
		
		if ($this->WidgetTraitTitle !== $newTitle) {
			$this->WidgetTraitTitle = $newTitle;
			$this->setChanged(true);
		}
		
		return $this;
	}
	
	
	
	
	/**
	 * Roles are defined and described by their characteristics. Characteristics define the structural function of a role, such as what a role is, concepts behind it, and what instances the role can or must contain. In the case of widgets this also includes how it interacts with the user agent based on mapping to HTML forms and XForms. States and properties from WAI-ARIA that are supported by the role are also indicated.
	 * 
	 * @var string
	 * @link http://www.w3.org/TR/html5/dom.html#aria-role-attribute
	 * @link http://www.w3.org/TR/wai-aria/roles
	 */
	private $WidgetTraitRole;
	
	/**
	 * @implements \nexxes\widgets\WidgetInterface
	 */
	public function getRole() {
		return $this->WidgetTraitRole;
	}
	
	/**
	 * @implements \nexxes\widgets\WidgetInterface
	 */
	public function setRole($newRole) {
		if (!\is_null($newRole) && !\is_string($newRole)) {
			throw new \InvalidArgumentException('Role can only be set to a string value!');
		}
		
		if ($this->WidgetTraitRole !== $newRole) {
			$this->WidgetTraitRole = $newRole;
			$this->setChanged(true);
		}
		
		return $this;
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
	private $WidgetTraitData = [];
	
	/**
	 * @implements \nexxes\widgets\WidgetInterface
	 */
	public function getData($name = null) {
		if (is_null($name)) {
			return $this->WidgetTraitData;
		}
		
		elseif (isset($this->WidgetTraitData[$name])) {
			return $this->WidgetTraitData[$name];
		}
		
		else {
			return null;
		}
	}
	
	/**
	 * @implements \nexxes\widgets\WidgetInterface
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
			if (isset($this->WidgetTraitData[$name])) {
				unset($this->WidgetTraitData[$name]);
				$this->setChanged(true);
			}
		}
		
		elseif (!\is_string($newValue)) {
			throw new \InvalidArgumentException('Can not set data attribute "' . $name . '" to a non-string value.');
		}
		
		elseif (!isset($this->WidgetTraitData[$name]) || ($this->WidgetTraitData[$name] !== $newValue)) {
			$this->WidgetTraitData[$name] = $newValue;
			$this->setChanged(true);
		}
		
		return $this;
	}
	
	protected function renderDataAttributes() {
		$r = '';
		
		foreach ($this->WidgetTraitData as $dataName => $dataValue) {
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
		\sort($this->WidgetTraitClasses);
		
		if ($this->eventDispatcher !== null) {
			$this->getID();
		}
		
		return (\is_null($this->WidgetTraitId) ? '' : ' id="' . $this->escape($this->WidgetTraitId) . '"')
			. (\count($this->WidgetTraitClasses) ? ' class="' . \join(' ', \array_map([$this, 'escape'], $this->WidgetTraitClasses)) . '"' : '')
			. $this->renderDataAttributes()
			. (\is_null($this->WidgetTraitRole) ? '' : ' role="' . $this->escape($this->WidgetTraitRole) . '"')
			. (\is_null($this->WidgetTraitTitle) ? '' : ' title="' . $this->escape($this->WidgetTraitTitle) . '"')
			. (\is_null($this->WidgetTraitTabindex) ? '' : ' tabindex="' . $this->WidgetTraitTabindex . '"')
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
	 * @implements WidgetInterface
	 * @see WidgetInterface::one() WidgetInterface::one()
	 */
	public function one($eventName, callable $listener, $priority = 50) {
		return $this->on($eventName, new EventHandlerCallOnceWrapper($listener), $priority);
	}
	
	/**
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
}
