<?php

namespace nexxes\widgets\html;

use nexxes\widgets\WidgetContainerInterface;
use nexxes\widgets\WidgetContainerTrait;
use nexxes\widgets\WidgetInterface;

/**
 * @author Dennis Birkholz <dennis.birkholz@nexxes.net>
 */
class Listing implements WidgetContainerInterface {
	use WidgetContainerTrait;
	
	/**
	 * Default constructor
	 * 
	 * @param \nexxes\widgets\WidgetInterface $parent
	 */
	public function __construct(WidgetInterface $parent) {
		$this->setParent($parent);
	}
	
	
	/**
	 * @var bool
	 */
	private $ordered = false;
	
	/**
	 * @return bool
	 */
	public function isOrdered() {
		return $this->ordered;
	}
	
	/**
	 * @param bool $newOrdered
	 * @return \nexxes\widgets\html\Listing $this for chaining
	 */
	public function setOrdered($newOrdered) {
		if (!is_bool($newOrdered)) {
			throw new \InvalidArgumentException('Supplied value is not a boolean!');
		}
		
		if ($newOrdered != $this->ordered) {
			$this->ordered = $newOrdered;
			$this->setChanged(true);
		}
		
		return $this;
	}
	
	
	/**
	 * @var int
	 * @link http://www.w3.org/TR/html5/grouping-content.html#attr-ol-start
	 */
	private $start;
	
	/**
	 * @return int
	 * @link http://www.w3.org/TR/html5/grouping-content.html#attr-ol-start
	 */
	public function getStart() {
		return $this->start;
	}
	
	/**
	 * @param int $newStart Ordinal value of the first item
	 * @return \nexxes\widgets\html\Listing $this for chaining 
	 * @link http://www.w3.org/TR/html5/grouping-content.html#attr-ol-start
	 */
	public function setStart($newStart) {
		if (!is_int($newStart)) {
			throw new \InvalidArgumentException('The start value of a list must be an integer.');
		}
		
		if ($newStart !== $this->start) {
			$this->start = $newStart;
			$this->setChanged(true);
		}
		
		return $this;
	}
	
	
	/**
	 * @var bool
	 * @link http://www.w3.org/TR/html5/grouping-content.html#attr-ol-reversed
	 */
	private $reversed = false;
	
	/**
	 * @return bool
	 * @link http://www.w3.org/TR/html5/grouping-content.html#attr-ol-reversed
	 */
	public function isReversed() {
		return $this->reversed;
	}
	
	/**
	 * 
	 * @return \nexxes\widgets\html\Listing $this for chaining
	 * @link http://www.w3.org/TR/html5/grouping-content.html#attr-ol-reversed
	 */
	public function setReversed($newReversed) {
		if (!is_bool($newReversed)) {
			throw new \InvalidArgumentException('The reversed flag of a list must be a boolean.');
		}
		
		if ($newReversed !== $this->reversed) {
			$this->reversed = $newReversed;
			$this->setChanged(true);
		}
		
		return $this;
	}
	
	
	/**
	 * List uses decimal numbers (1. 2. 3. ...)
	 * @link http://www.w3.org/TR/html5/grouping-content.html#attr-ol-type
	 */
	const TYPE_DECIMAL = '1';
	
	/**
	 * List uses lowercase latin alphabet (a. b. c. ...)
	 * @link http://www.w3.org/TR/html5/grouping-content.html#attr-ol-type
	 */
	const TYPE_LOWER_ALPHA = 'a';
	
	/**
	 * List uses uppercase latin alphabet (A. B. C. ...)
	 * @link http://www.w3.org/TR/html5/grouping-content.html#attr-ol-type
	 */
	const TYPE_UPPER_ALPHA = 'A';
	
	/**
	 * List uses lowercase roman numerals (i. ii. iii. iv. ...)
	 * @link http://www.w3.org/TR/html5/grouping-content.html#attr-ol-type
	 */
	const TYPE_LOWER_ROMAN = 'i';
	
	/**
	 * List uses uppercase roman numerals (I. II. III. IV. ...)
	 * @link http://www.w3.org/TR/html5/grouping-content.html#attr-ol-type
	 */
	const TYPE_UPPER_ROMAN = 'I';
	
	/**
	 * Type of the listing, one of the TYPE_* constants
	 * @link http://www.w3.org/TR/html5/grouping-content.html#attr-ol-type
	 */
	private $type;
	
	/**
	 * Get the current type if list is ordered
	 * @return string
	 * @link http://www.w3.org/TR/html5/grouping-content.html#attr-ol-type
	 */
	public function getType() {
		if (!$this->ordered) {
			throw new \InvalidArgumentException('Unordered list has not list item type!');
		}
		
		return $this->type;
	}
	
	/**
	 * Set the current type if the list is ordered
	 * @param mixed $newType
	 * @return \nexxes\widgets\html\Listing $this for chaining
	 * @link http://www.w3.org/TR/html5/grouping-content.html#attr-ol-type
	 */
	public function setType($newType) {
		$constants = (new \ReflectionClass(self::class))->getConstants();
		
		if (!$this->isOrdered()) {
			throw new \InvalidArgumentException('Can not set list type for unordered list.');
		}
		
		if (!\in_array($newType, \array_values($constants))) {
			throw new \UnexpectedValueException('Invalid list type "' . $newType . '", valid types are: ' . __CLASS__ . '::' . \implode(', ' . __CLASS__ . '::', \array_keys($constants)));
		}
		
		if ($newType !== $this->type) {
			$this->type = $newType;
			$this->setChanged(true);
		}
		
		return $this;
	}
	
	
	/**
	 * Render the widget as html
	 * 
	 * @return string
	 */
	public function __toString() {
		$r = '<' . ($this->isOrdered() ? 'ol' : 'ul')
			. $this->getAttributesHTML()
			. ($this->isReversed() ? ' reversed="reversed"' : '')
			. ($this->getStart() !== null ? ' start="' . $this->escape($this->getStart()) . '"' : '')
			. ($this->isOrdered() && ($this->getType() !== null) ? ' type="' . $this->escape($this->getType()) . '"' : '')
			. '>';
		
		foreach ($this AS $child) {
			$r .= $child;
		}
		
		$r .= '</' . ($this->isOrdered() ? 'ol' : 'ul') . '>';
		return $r;
	}
	
	/**
	 * Enforce that only list elements can be members of a list
	 */
	protected function validateWidget($widget) {
		if (!($widget instanceof ListElement)) {
			throw new \InvalidArgumentException('A list can only contain ' . ListElement::class . ' elements.');
		}
	}
}