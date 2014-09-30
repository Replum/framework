<?php

namespace nexxes\widgets\html;

use \nexxes\widgets\WidgetInterface;
use \nexxes\widgets\WidgetTrait;

/**
 * @author Dennis Birkholz <dennis.birkholz@nexxes.net>
 */
class Text implements WidgetInterface, PhrasingContentInterface {
	use WidgetTrait;
	
	/**
	 * The text value of this Text widget
	 * 
	 * @var string
	 */
	private $text = '';
	
	/**
	 * @return string
	 */
	public function getText() {
		return $this->text;
	}
	
	/**
	 * @param type $newText
	 * @return \nexxes\widgets\html\Text $this for chaining
	 */
	public function setText($newText) {
		if (!is_string($newText)) {
			throw new \InvalidArgumentException('Supplied text value must be a string.');
		}
		
		if ($newText !== $this->text) {
			$this->text = $newText;
			$this->setChanged(true);
		}
		
		return $this;
	}
	
	/**
	 * The tag this text is rendered with.
	 * If the type is not explicitly set and not attribute needs rendering, no tag is rendered.
	 * If the type is set, a tag will render regarless of the attribute values.
	 * If the attribute values require a tag to be rendered, '<span>' is used if no type is specified.
	 * 
	 * @var string
	 */
	private $type;
	
	/**
	 * @return string
	 */
	public function getType() {
		return $this->type;
	}
	
	/**
	 * @param string $newType The tag type to set
	 * @return \nexxes\widgets\html\Text $this for chaining
	 */
	public function setType($newType) {
		if (!in_array($newType, $this->validTypes())) {
			throw new \InvalidArgumentException('Invalid type "' . $newType . '" supplied! Allowed values are: "' . \implode('", "', $this->validTypes()) . '"');
		}
		
		if ($newType !== $this->type) {
			$this->type = $newType;
			$this->setChanged(true);
		}
		
		return $this;
	}
	
	/**
	 * @return array<string> The list of possible types to set via setType()
	 */
	public function validTypes() {
		return [ 'span', 'div', 'p', 'h1', 'h2', 'h3', 'h4', 'h5', 'h6', 'a', 'legend', ];
	}
	
	public function __construct(WidgetInterface $parent = null) {
		if ($parent !== null) { $this->setParent($parent); }
	}
	
	public function __toString() {
		$attributes = $this->getAttributesHTML();
		
		if (!is_null($this->type) || ($attributes != '')) {
			return '<' . ($this->type ?: 'span') . $attributes . '>' . $this->escape($this->text) . '</' . ($this->type ?: 'span') . '>';
		} else {
			return $this->escape($this->text);
		}
	}
}
