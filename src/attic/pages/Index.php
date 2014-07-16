<?php

namespace nexxes\pages;

use \nexxes\PageContext;
use \nexxes\DoctrineDataSource;
use \nexxes\widgets;

class Index extends \nexxes\Page {
	protected $table;
	
	public function __construct() {
		parent::__construct();
		$this->table = new widgets\Table();
		$this->addWidget($this->table);
	}
	
	public function render() {
		$this->initWidget($this->table);
		$this->table->updateValues();
		
		print $this->renderHTML();
	}
	
	public function initWidget(\nexxes\iWidget $widget) {
		if ($this->table == $widget) {
			$g = new \guild\ModelManager();
			$ds = new DoctrineDataSource($g->doctrine, 'guild\Char', ['name', 'account.name'], ['name'=>'Char', 'account.name'=>'Account']);
			$this->table->setDataSource($ds);
		}
	}
}
