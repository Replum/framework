<?php

namespace nexxes\widgets;

trait WidgetTrait {
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
	public function setParent(WidgetInterface $newParent) {
		// Avoid recursion
		if ($this->WidgetTraitParent === $newParent) {
			return $this;
		}
		
		$this->WidgetTraitParent = $newParent;
		
		// Add to parent if it is a widget container (not for composites!)
		if (($newParent instanceof WidgetContainerInterface) && (!$newParent->hasChild($this))) {
			$newParent[] = $this;
		}
		
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
		
		if ($this instanceof \nexxes\widgets\PageInterface) {
			return $this;
		}
		
		$this->WidgetTraitPage = $this->getParent()->getPage();
		return $this->WidgetTraitPage;
	}
	
	
	
	
	/**
	 * @var boolean
	 */
	private $WidgetTraitChanged = false;
	
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
		$this->WidgetTraitChanged = $changed;
		
		// If the current widget is not identifiable, it is not available in the list of widgets and can not be replaced in the web page.
		// Mark the parent widget as changed so it is re-rendered including this widget
		if ($changed && is_null($this->getID()) && !$this->isRoot()) {
			$this->getParent()->setChanged($changed);
		}
		
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
	 * @implements \nexxes\widgets\IdentifiableInterface
	 */
	public function getID() {
		return $this->WidgetTraitId;
	}
	
	/**
	 * @implements \nexxes\widgets\IdentifiableInterface
	 */
	public function setID($newID, $skipNotify = false) {
		$oldID = $this->WidgetTraitId;
		$this->WidgetTraitId = $newID;
		
		// Prevent recursion
		if ($skipNotify || ($oldID === $newID)) {
			return $this;
		}
		
		/* @var $registry WidgetRegistry */
		$registry = $this->getPage()->getWidgetRegistry();
		$registry->notifyIdChange($this);
		
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
			throw new \InvalidArgumentException('TabIndex can only be set to an integer value!');
		}
		
		if ($this->WidgetTraitTabindex !== $newTabIndex) {
			$this->WidgetTraitTabindex = (int)$newTabIndex;
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
	 * Get a HTML representation of the widget
	 * 
	 * @return string
	 * @codeCoverageIgnore
	 */
	protected function getAttributesHTML() {
		\sort($this->WidgetTraitClasses);
		
		return (\is_null($this->WidgetTraitId) ? '' : ' id="' . $this->escape($this->WidgetTraitId) . '"')
			. (\count($this->WidgetTraitClasses) ? ' class="' . \join(' ', \array_map([$this, 'escape'], $this->WidgetTraitClasses)) . '"' : '')
			. (\is_null($this->WidgetTraitTitle) ? '' : ' title="' . $this->escape($this->WidgetTraitTitle) . '"')
			. (\is_null($this->WidgetTraitTabindex) ? '' : ' tabindex="' . $this->WidgetTraitTabindex . '"')
		;
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
}
