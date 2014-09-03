<?php

namespace nexxes\widgets\bootstrap;

use \nexxes\widgets\html\FormElement;
use \nexxes\widgets\html\FormElementInterface;
use \nexxes\widgets\WidgetCompositeInterface;
use \nexxes\widgets\WidgetCompositeTrait;

/**
 * @author Dennis Birkholz <dennis.birkholz@nexxes.net>
 */
class FormGroup extends FormElement implements FormElementInterface, WidgetCompositeInterface {
	use WidgetCompositeTrait;
	
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
	
	
	
	
	
	public function __construct(\nexxes\widgets\WidgetInterface $parent) {
		$this->setParent($parent);
		$this->getPage()->getWidgetRegistry()->register($this);
		
		$this->childSlot('label');
		$this->childSlot('element');
	}
	
	public function __toString() {
		$this->addClass('form-group');
		
		$r = '<div'
			. $this->getAttributesHTML()
			. '>' . PHP_EOL
			. '<label class="control-label col-lg-2" for="' . $this['element']->getID() . '">' . $this['element']->getName() . '</label>' . PHP_EOL
			. ($this['label'] ?: "")
			. '<div class="col-lg-10">' . ($this['element'] ?: "")
		;
		
		if ($this->hasFeedback()) {
			if ($this->hasSuccess()) {
				$r .= '<span class="glyphicon glyphicon-ok form-control-feedback"></span>' . PHP_EOL;
			} elseif ($this->hasWarning()) {
				$r .= '<span class="glyphicon glyphicon-warning-sign form-control-feedback"></span>' . PHP_EOL;
			} elseif ($this->hasError()) {
				$r .= '<span class="glyphicon glyphicon-remove sign form-control-feedback"></span>' . PHP_EOL;
			}
		}
		
		$r .= '<span class="help-block">A block of help text that breaks onto a new line and may extend beyond one line.A block of help text that breaks onto a new line and may extend beyond one line.</span>'  . PHP_EOL
			. '</div>'  . PHP_EOL
			. '<script>window.setTimeout(function(){ console.log("Remove element"); $("#' . $this->getID() . '").removeClass("has-success"); $("#' . $this->getID() . ' .form-control-feedback").addClass("hidden"); }, 5000);</script>'  . PHP_EOL
			. '</div>'  . PHP_EOL
		;
		
		return $r;
	}
}
