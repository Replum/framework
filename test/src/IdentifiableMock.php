<?php

namespace nexxes\widgets;

class IdentifiableMock implements interfaces\Identifiable {
	protected $id;
	
	public function add($property, $value) {
		
	}

	public function del($property, $value) {
		
	}

	public function getID() {
		return $this->id;
	}

	public function renderHTML() {
		
	}

	public function set($property, $value) {
		
	}

	public function setID($newID) {
		$this->id = $newID;
	}

}

