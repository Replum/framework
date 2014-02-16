<?php

namespace nexxes\pages;

use \nexxes\DoctrineDataSource;
use \nexxes\widgets;

class Form extends \nexxes\Page {
	protected $form;
	
	protected $char1;
	protected $char2;
	protected $char3;
	protected $char4;
	protected $char5;
	
	public function __construct() {
		parent::__construct();
		$this->form = new widgets\Form();
		$this->form->layout = 'horizontal';
		//$this->form->title = "Dungeon-Run eintragen";
		
		for ($i=1; $i<=5; $i++) {
			$input = new widgets\form\Input('Char' . $i, 'Teilnehmenden Character ' . $i . ' auswählen.', 'Teilnehmender Character ' . $i);
			if ($i == 1) $input->classes[] = 'guild-char-input';
			$this->{"char$i"} = $input;
			$this->form->addWidget($input);
		}
		
		$g = new \guild\ModelManager();
		$dungeons = $g->findAll('guild\Dungeon');
		$values = [];
		foreach ($dungeons AS $dungeon) {
			$values[$dungeon->name] = $dungeon->name . " / " . $dungeon->de;
		}
		$this->form->addWidget(new widgets\form\Select($values, 'Dungeon'));
		
		
		$this->form->addButton(new widgets\form\Button("Eintragen"));
		$this->form->addButton(new widgets\form\Button("Zurücksetzen"));
		
		$this->addWidget($this->form);
	}
	
	public function initWidget(\nexxes\iWidget $widget) {
		if ($widget == $this->form) {
			$widget->widgets()[0]->error = true;
			$widget->errortitle = "Kann Formular nicht abschicken";
			$widget->errors["Fehler"] = "Bitte char auswählen";
		}
	}
}
