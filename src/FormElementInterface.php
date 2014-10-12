<?php

/*
 * This file is part of the nexxes/widgets-html package.
 * 
 * Copyright (c) Dennis Birkholz, nexxes Informationstechnik GmbH <dennis.birkholz@nexxes.net>
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

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
	 * Should only be used by handlers that manage form association,
	 * 
	 * @param Form $form
	 * @return FormElementInterface $this for chaining
	 */
	function setForm(Form $form);
}
