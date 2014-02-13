<?php

namespace nexxes\widgets;

use \nexxes\PageContext;
use \nexxes\property\Config;

class Table extends \nexxes\Widget {
	/**
	 * 
	 * @var string
	 * @Config(type="string", fill=true)
	 */
	public $sort;
	
	/**
	 *
	 * @var string asc|desc
	 * @Config(type="string", fill=true, match="/^asc|desc$/")
	 */
	public $order = 'asc';
	
	/**
	 * The datasource to use
	 * @var \nexxes\iDataSource
	 */
	private $ds;
	
	
	public function __construct(\nexxes\iDataSource $ds = null) {
		parent::__construct();
		$this->ds = $ds;
	}
	
	public function renderHTML() {
		if ($this->sort) {
			$this->ds->sort($this->sort, $this->order);
		}
		
		$s = $this->smarty();
		$s->assign('datasource', $this->ds);
		$s->assign('sort', $this->sort);
		$s->assign('order', $this->order);
		
		return $s->fetch(__DIR__ . '/Table.tpl');
	}
	
	public function setDataSource(\nexxes\iDataSource $ds = null) {
		$this->ds = $ds;
	}
}
