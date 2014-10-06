<?php

namespace nexxes\widgets\html;

use \nexxes\widgets\WidgetInterface;

/**
 *
 * @author Dennis Birkholz <dennis.birkholz@nexxes.net>
 */
interface FormElementInterface extends WidgetInterface {
	/**
	 * Get the form this FormElement is associated with
	 * 
	 * @return Form
	 */
	function getForm();
	
	/**
	 * Set the form for the FormElement
	 * @param Form $form
	 */
	function setForm(Form $form);
}
