<?php

namespace nexxes\widgets\html;

use \nexxes\widgets;

/**
 *
 * @author Dennis Birkholz <dennis.birkholz@nexxes.net>
 */
interface FormElementInterface extends widgets\HTMLWidgetInterface, widgets\IdentifiableInterface {
	/**
	 * Get the form this FormElement is associated with
	 * 
	 * @return \nexxes\widgets\html\Form
	 */
	function getForm();
	
	
}