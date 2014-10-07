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
		return $this->FormElementTraitForm;
	}
	
	/**
	 * @implements FormElementInterface
	 * {@inheritdoc}
	 */
	public function setForm(Form $form) {
		$this->FormElementTraitForm = $form;
	}
}
