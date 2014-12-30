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

/**
 * @author Dennis Birkholz <dennis.birkholz@nexxes.net>
 * @property-read Form $form Formular containing this button (if any)
 */
trait FormElementTrait {
	/**
	 * @var Form
	 */
	private $FormElementTraitForm;
	
	/**
	 * @implements FormElementInterface
	 * {@inheritdoc}
	 */
	public function getForm() {
		if ($this->FormElementTraitForm !== null) {
			return $this->FormElementTraitForm;
		}
		
		return $this->getNearestAncestor(Form::class);
	}
	
	/**
	 * @implements FormElementInterface
	 * {@inheritdoc}
	 */
	public function setForm(Form $form) {
		$this->FormElementTraitForm = $form;
	}
}
