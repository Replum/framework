<?php

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
