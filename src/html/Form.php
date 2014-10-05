<?php

namespace nexxes\widgets\html;

use \nexxes\widgets\WidgetContainer;
use \nexxes\widgets\WidgetCollection;
use \nexxes\widgets\WidgetInterface;

/**
 * @author Dennis Birkholz <dennis.birkholz@nexxes.net>
 */
class Form extends WidgetContainer {
	/**
	 * @var string
	 * @link http://www.w3.org/TR/html5/forms.html#attr-fs-action
	 */
	private $action;
	
	/**
	 * @return string
	 * @link http://www.w3.org/TR/html5/forms.html#attr-fs-action
	 */
	public function getAction() {
		return $this->action;
	}
	
	/**
	 * @param string $newAction
	 * @return \nexxes\widgets\html\Form $this for chaining
	 * @link http://www.w3.org/TR/html5/forms.html#attr-fs-action
	 */
	public function setAction($newAction) {
		if ($newAction !== $this->action) {
			$this->action = $newAction;
			$this->setChanged(true);
		}
		
		return $this;
	}
	
	
	/**
	 * @var string
	 * @link http://www.w3.org/TR/html5/forms.html#attr-form-name
	 */
	private $name;
	
	/**
	 * @return string
	 * @link http://www.w3.org/TR/html5/forms.html#attr-form-name
	 */
	public function getName() {
		return $this->action;
	}
	
	/**
	 * @param string $newName
	 * @return \nexxes\widgets\html\Form $this for chaining
	 * @link http://www.w3.org/TR/html5/forms.html#attr-form-name
	 */
	public function setName($newName) {
		if ($newName !== $this->name) {
			$this->name = $newName;
			$this->setChanged(true);
		}
		
		return $this;
	}
	
	
	/**
	 * {@inheritdoc}
	 */
	public function setParent(WidgetInterface $newParent) {
		parent::setParent($newParent);
		
		if ($this->isChanged()) {
			$ancestors = \array_reverse($this->getAncestors());
			
			foreach ($ancestors AS $ancestor) {
				if ($ancestor instanceof Form) {
					throw new \InvalidArgumentException('A form element can not contain another form element, see: http://www.w3.org/TR/html5/forms.html#the-form-element');
				}
			}
		}
		
		return $this;
	}
	
	
	/**
	 * @var WidgetCollection 
	 */
	private $elements;
	
	public function elements() {
		if (is_null($this->elements)) {
			$this->elements = new WidgetCollection($this);
		}
		
		return $this->elements;
	}
	
	
	public function __toString() {
		$r = '<form role="form"'
			. $this->renderAttributes()
			. '>' . "\n";
		
		foreach ($this->children() AS $widget) {
			$r .= $widget . "\n";
		}
		
		$r .= '</form>' . "\n";
		
		return $r;
	}
}
