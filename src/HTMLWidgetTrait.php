<?php

namespace nexxes\widgets;

trait HTMLWidgetTrait {
	/**
	 * The list of classes this html widgets has
	 * 
	 * @var array<string>
	 * @see http://www.w3.org/TR/html5/dom.html#classes
	 */
	private $HTMLWidgetTraitClasses = [];
	
	/**
	 *  @implements \nexxes\widgets\HTMLWidgetInterface
	 */
	public function addClass($newClass) {
		if (!\in_array($newClass, $this->HTMLWidgetTraitClasses, true)) {
			$this->HTMLWidgetTraitClasses[] = $newClass;
			$this->setChanged(true);
		}
		
		return $this;
	}
	
	/**
	 * @implements \nexxes\widgets\HTMLWidgetInterface
	 */
	public function delClass($class, $isRegex = false) {
		// Regex matching
		if ($isRegex) {
			foreach ($this->HTMLWidgetTraitClasses AS $index => $checkClass) {
				if (\preg_match($class, $checkClass)) {
					unset($this->HTMLWidgetTraitClasses[$index]);
					$this->setChanged(true);
				}
			}
		}
		
		// Literal class name matching
		elseif (($key = \array_search($class, $this->HTMLWidgetTraitClasses)) !== false) {
			unset($this->HTMLWidgetTraitClasses[$key]);
			$this->setChanged(true);
		}
		
		return $this;
	}
	
	/**
	 * @implements \nexxes\widgets\HTMLWidgetInterface
	 */
	public function hasClass($class, $isRegex = false) {
		// Regex matching
		if ($isRegex) {
			foreach ($this->HTMLWidgetTraitClasses AS $checkClass) {
				if (\preg_match($class, $checkClass)) {
					return true;
				}
			}
			
			return false;
		}
		
		// Literal class name matching
		else {
			return \in_array($class, $this->HTMLWidgetTraitClasses);
		}
	}
	
	/**
	 * @implements \nexxes\widgets\HTMLWidgetInterface
	 */
	public function getClasses($regex = null) {
		\sort($this->HTMLWidgetTraitClasses);
		
		// Get only classes matching the supplied regex
		if (!is_null($regex)) {
			$found = [];
			foreach ($this->HTMLWidgetTraitClasses AS $class) {
				if (\preg_match($regex, $class)) {
					$found[] = $class;
				}
			}
			return $found;
		}
		
		// Get all classes
		else {
			return $this->HTMLWidgetTraitClasses;
		}
	}
	
	/**
	 * Get a HTML representation of the classes attribute.
	 * 
	 * @return string
	 */
	protected function getClassesHTML() {
		\sort($this->HTMLWidgetTraitClasses);
		return (\count($this->HTMLWidgetTraitClasses) ? ' class="' . \join(' ', \array_map([$this, 'escape'], $this->HTMLWidgetTraitClasses)) . '"' : '');
	}
	
	/**
	 * The tabindex content attribute allows authors to control whether an element is supposed to be focusable, whether it is supposed to be reachable using sequential focus navigation, and what is to be the relative order of the element for the purposes of sequential focus navigation. The name "tab index" comes from the common use of the "tab" key to navigate through the focusable elements. The term "tabbing" refers to moving forward through the focusable elements that can be reached using sequential focus navigation.
	 * 
	 * @var int
	 * @see http://www.w3.org/TR/html5/editing.html#attr-tabindex
	 */
	private $HTMLWidgetTraitTabindex;
	
	/**
	 * @implements \nexxes\widgets\HTMLWidgetInterface
	 */
	public function getTabIndex() {
		return $this->HTMLWidgetTraitTabindex;
	}
	
	/**
	 * @implements \nexxes\widgets\HTMLWidgetInterface
	 */
	public function setTabIndex($newTabIndex) {
		if (!\is_null($newTabIndex) && !\is_int($newTabIndex)) {
			throw new \InvalidArgumentException('TabIndex can only be set to an integer value!');
		}
		
		if ($this->HTMLWidgetTraitTabindex !== $newTabIndex) {
			$this->HTMLWidgetTraitTabindex = (int)$newTabIndex;
			$this->setChanged(true);
		}
		
		return $this;
	}
	
	/**
	 * Get a HTML representation of the tabindex attribute.
	 * 
	 * @return string
	 */
	protected function getTabIndexHTML() {
		return (\is_null($this->HTMLWidgetTraitTabindex) ? '' : ' tabindex="' . $this->HTMLWidgetTraitTabindex . '"');
	}
	
	/**
	 * The title attribute represents advisory information for the element, such as would be appropriate for a tooltip. On a link, this could be the title or a description of the target resource; on an image, it could be the image credit or a description of the image; on a paragraph, it could be a footnote or commentary on the text; on a citation, it could be further information about the source; on interactive content, it could be a label for, or instructions for, use of the element; and so forth. The value is text.
	 * 
	 * @var string
	 * @see http://www.w3.org/TR/html5/dom.html#attr-title
	 */
	private $HTMLWidgetTraitTitle;
	
	/**
	 * @implements \nexxes\widgets\HTMLWidgetInterface
	 */
	public function getTitle() {
		return $this->HTMLWidgetTraitTitle;
	}
	
	/**
	 * @implements \nexxes\widgets\HTMLWidgetInterface
	 */
	public function setTitle($newTitle) {
		if (!\is_null($newTitle) && !\is_string($newTitle)) {
			throw new \InvalidArgumentException('Title can only be set to a string value!');
		}
		
		if ($this->HTMLWidgetTraitTitle !== $newTitle) {
			$this->HTMLWidgetTraitTitle = $newTitle;
			$this->setChanged(true);
		}
		
		return $this;
	}
	
	/**
	 * Get a HTML representation of the title attribute.
	 * 
	 * @return string
	 */
	protected function getTitleHTML() {
		return (\is_null($this->HTMLWidgetTraitTitle) ? '' : ' title="' . $this->escape($this->HTMLWidgetTraitTitle) . '"');
	}
	
	/**
	 * Make the supplied data safe to use it in an HTML document
	 * 
	 * @param string $string
	 * @return string
	 */
	protected function escape($string) {
		return \htmlentities($string, ENT_HTML5, 'UTF-8');
	}
}
