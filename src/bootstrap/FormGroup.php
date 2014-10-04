<?php

namespace nexxes\widgets\bootstrap;

use \nexxes\widgets\html\FormElementInterface;
use \nexxes\widgets\html\FormElementTrait;
use \nexxes\widgets\WidgetInterface;
use \nexxes\widgets\WidgetCompositeInterface;
use \nexxes\widgets\WidgetCompositeTrait;

/**
 * @author Dennis Birkholz <dennis.birkholz@nexxes.net>
 */
class FormGroup implements WidgetCompositeInterface, FormElementInterface {
	use WidgetCompositeTrait, FormElementTrait;
	
	/**
	 * Get success status of this form element
	 * 
	 * @return boolean
	 */
	public function hasSuccess() {
		return $this->hasClass('has-success');
	}
	
	/**
	 * Set the success flag for this form element
	 * 
	 * @param boolean
	 * @return \nexxes\widgets\bootstrap\FormGroup $this for chaining
	 */
	public function setSuccess($newSuccess) {
		if ($newSuccess) {
			$this->addClass('has-success');
			$this->delClass('has-warning');
			$this->delClass('has-error');
		} else {
			$this->delClass('has-success');
		}
		
		return $this;
	}
	
	/**
	 * Get warning status of this form element
	 * 
	 * @return boolean
	 */
	public function hasWarning() {
		return $this->hasClass('has-warning');
	}
	
	/**
	 * Set the warning flag for this form element
	 * 
	 * @param boolean
	 * @return \nexxes\widgets\bootstrap\FormGroup $this for chaining
	 */
	public function setWarning($newWarning) {
		if ($newWarning) {
			$this->delClass('has-success');
			$this->addClass('has-warning');
			$this->delClass('has-error');
		} else {
			$this->delClass('has-warning');
		}
		
		return $this;
	}
	
	/**
	 * Get error status of this form element
	 * 
	 * @return boolean
	 */
	public function hasError() {
		return $this->hasClass('has-error');
	}
	
	/**
	 * Set the error flag for this form element
	 * 
	 * @param boolean
	 * @return \nexxes\widgets\bootstrap\FormGroup $this for chaining
	 */
	public function setError($newError) {
		if ($newError) {
			$this->delClass('has-success');
			$this->delClass('has-warning');
			$this->addClass('has-error');
		} else {
			$this->delClass('has-error');
		}
		
		return $this;
	}
	
	/**
	 * Get feedback status of this form element
	 * 
	 * @return boolean
	 */
	public function hasFeedback() {
		return $this->hasClass('has-feedback');
	}
	
	/**
	 * Set the feedback enabled flag for this form element
	 * 
	 * @param boolean
	 * @return \nexxes\widgets\bootstrap\FormGroup $this for chaining
	 */
	public function setFeedback($newFeedback) {
		if ($newFeedback) {
			$this->addClass('has-feedback');
		} else {
			$this->delClass('has-feedback');
		}
		
		return $this;
	}
	
	
	
	
	
	public function __construct(WidgetInterface $parent = null) {
		if ($parent !== null) { $this->setParent($parent); }
		
		$this->childSlot('label');
		$this->childSlot('element');
		$this->childSlot('help');
		
	}
	
	public function __toString() {
		// Formgroup should have an ID, so enforce it (late)
		$this->setID();
		
		$this->addClass('form-group');
		$this->addClass('form-group-sm');
		
		if (isset($this['label'])) {
			// Assign form element to label
			if (($this['label']->getFor() === null) && isset($this['element'])) {
				$this['label']->setFor($this['element']);
			}
			
			// Set default label classes
			$this['label']->addClass('control-label');
			$this['label']->addClass('col-lg-3');
		}
		
		if ($this->hasFeedback()) {
			if ($this->hasSuccess()) {
				$icon = (new Glyphicon('ok'))->addClass('form-control-feedback');
			} elseif ($this->hasWarning()) {
				$icon = (new Glyphicon('warning-sign'))->addClass('form-control-feedback');
			} elseif ($this->hasError()) {
				$icon = (new Glyphicon('remove'))->addClass('form-control-feedback');
			}
		}
		
		if (isset($this['help'])) {
			$this['help']->addClass('help-block');
		}
		
		$inline = false;
		
		$r = '<div' . $this->getAttributesHTML() . '>' . PHP_EOL
			. ($this['label'] ?: "")
			. (!$inline ? '<div class="col-lg-9">' : '')
			. ($this['element'] ?: "")
			. (isset($icon) ? $icon : '')
			. ($this['help'] ?: "")
			. (!$inline ? '</div>' : '')
			//. '<script>window.setTimeout(function(){ console.log("Remove element"); $("#' . $this->getID() . '").removeClass("has-"); $("#' . $this->getID() . ' .form-control-feedback").addClass("hidden"); }, 5000);</script>'  . PHP_EOL
			. '</div>'  . PHP_EOL;
		
		return $r;
	}
}
