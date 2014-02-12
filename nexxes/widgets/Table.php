<?php

namespace nexxes\widgets;

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
	 * @var \nexxes\DataSourceInterface
	 */
	private $ds;
	
	
	public function __construct(\nexxes\PageContext $context, \nexxes\DataSourceInterface $ds = null) {
		parent::__construct($context);
		$this->ds = $ds;
	}
	
	public function renderHTML() {
		if ($this->sort) {
			$this->ds->sort($this->sort, $this->order);
		}
		
		$s = $this->getContext()->smarty;
		$s->assign('id', $this->id);
		$s->assign('datasource', $this->ds);
		$s->assign('sort', $this->sort);
		$s->assign('order', $this->order);
		
		return $s->fetch(__DIR__ . '/Table.tpl');
	}
}
