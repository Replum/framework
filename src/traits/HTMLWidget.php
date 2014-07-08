<?php

namespace nexxes\widgets\traits;

trait HTMLWidget {
	/**
	 * The list of classes this html widgets has
	 * 
	 * @var array<string>
	 * @see http://www.w3.org/TR/html5/dom.html#classes
	 */
	private $classes = [];
	
	/**
	 *  @implements \nexxes\widgets\interfaces\HTMLWidget
	 */
	public function addClass($newClass) {
		if (!\in_array($newClass, $this->classes, true)) {
			$this->classes[] = $newClass;
		}
		
		return $this;
	}
	
	/**
	 * @implements \nexxes\widgets\interfaces\HTMLWidget
	 */
	public function delClass($newClass) {
		if (($key = \array_search($newClass, $this->classes)) !== false) {
			unset($this->classes[$key]);
		}
		
		return $this;
	}
	
	/**
	 * @implements \nexxes\widgets\interfaces\HTMLWidget
	 */
	public function hasClass($class) {
		return \in_array($class, $this->classes);
	}
	
	/**
	 * @implements \nexxes\widgets\interfaces\HTMLWidget
	 */
	public function getClasses() {
		\sort($this->classes);
		return $this->classes;
	}
	
	/**
	 * Get a HTML representation of the classes attribute.
	 * 
	 * @return string
	 */
	protected function getClassesHTML() {
		\sort($this->classes);
		return (\count($this->classes) ? ' class="' . \join(' ', \array_map([$this, 'escape'], $this->classes)) . '"' : '');
	}
	
	/**
	 * The tabindex content attribute allows authors to control whether an element is supposed to be focusable, whether it is supposed to be reachable using sequential focus navigation, and what is to be the relative order of the element for the purposes of sequential focus navigation. The name "tab index" comes from the common use of the "tab" key to navigate through the focusable elements. The term "tabbing" refers to moving forward through the focusable elements that can be reached using sequential focus navigation.
	 * 
	 * @var int
	 * @see http://www.w3.org/TR/html5/editing.html#attr-tabindex
	 */
	private $tabindex;
	
	/**
	 * @implements \nexxes\widgets\interfaces\HTMLWidget
	 */
	public function getTabIndex() {
		return $this->tabindex;
	}
	
	/**
	 * @implements \nexxes\widgets\interfaces\HTMLWidget
	 */
	public function setTabIndex($newTabIndex) {
		if (!\is_null($newTabIndex) && !\is_int($newTabIndex)) {
			throw new \InvalidArgumentException('TabIndex can only be set to an integer value!');
		}
		
		$this->tabindex = (int)$newTabIndex;
		
		return $this;
	}
	
	/**
	 * Get a HTML representation of the tabindex attribute.
	 * 
	 * @return string
	 */
	protected function getTabIndexHTML() {
		return (\is_null($this->tabindex) ? '' : ' tabindex="' . $this->tabindex . '"');
	}
	
	/**
	 * The title attribute represents advisory information for the element, such as would be appropriate for a tooltip. On a link, this could be the title or a description of the target resource; on an image, it could be the image credit or a description of the image; on a paragraph, it could be a footnote or commentary on the text; on a citation, it could be further information about the source; on interactive content, it could be a label for, or instructions for, use of the element; and so forth. The value is text.
	 * 
	 * @var string
	 * @see http://www.w3.org/TR/html5/dom.html#attr-title
	 */
	private $title;
	
	/**
	 * @implements \nexxes\widgets\interfaces\HTMLWidget
	 */
	public function getTitle() {
		return $this->title;
	}
	
	/**
	 * @implements \nexxes\widgets\interfaces\HTMLWidget
	 */
	public function setTitle($newTitle) {
		if (!\is_null($newTitle) && !\is_string($newTitle)) {
			throw new \InvalidArgumentException('Title can only be set to a string value!');
		}
		
		$this->title = $newTitle;
		
		return $this;
	}
	
	/**
	 * Get a HTML representation of the title attribute.
	 * 
	 * @return string
	 */
	protected function getTitleHTML() {
		return (\is_null($this->title) ? '' : ' title="' . $this->escape($this->title) . '"');
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
