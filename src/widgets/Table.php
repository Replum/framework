<?php

namespace nexxes\widgets;

use \nexxes\PageContext;
use \nexxes\property\Config;

class Table extends \nexxes\Widget implements iPanelChild {
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
	
	/**
	 * @var bool
	 * @Config(type="bool")
	 */
	public $bordered = true;
	
	/**
	 * @var bool
	 * @Config(type="bool")
	 */
	public $condensed = true;
	
	/**
	 * @var bool
	 * @Config(type="bool")
	 */
	public $hover = true;
	
	/**
	 * @var bool
	 * @Config(type="bool")
	 */
	public $striped = true;
	
	/**
	 * @var int
	 * @Config(type="int", fill=true)
	 */
	public $page = 1;
	
	/**
	 * @var int
	 * @Config(type="int")
	 */
	public $rowsPerPage = 15;
	
	/**
	 * @var array<callable>
	 */
	protected $actionGenerators = [];
	
	/**
	 * @var array<callable>
	 */
	protected $fieldTranslators = [];
	
	
	
	
	public function __construct(\nexxes\iDataSource $ds = null) {
		parent::__construct();
		$this->ds = $ds;
		
		$this->addClass('table');
		$this->addClass('nexxesSimpleWidget');
	}
	
	public function renderHTML() {
		if ($this->sort) {
			$this->ds->sort($this->sort, $this->order);
		}
		
		foreach(['bordered', 'condensed', 'hover', 'striped',] AS $setting) {
			if ($this->$setting) {
				$this->addClass('table-' . $setting);
			} else {
				$this->delClass('table-' . $setting);
			}
		}
		
		$this->ds->limit(($this->page -1) * $this->rowsPerPage, $this->rowsPerPage);
		
		$s = $this->smarty();
		$s->assign('datasource', $this->ds);
		$s->assign('sort', $this->sort);
		$s->assign('order', $this->order);
		
		return $s->fetch(__DIR__ . '/Table.tpl');
	}
	
	public function setDataSource(\nexxes\iDataSource $ds = null) {
		$this->ds = $ds;
	}
	
	public function serialize() {
		unset($this->ds);
		return parent::serialize();
	}
	
	public function pages() {
		return \ceil(\count($this->ds) / $this->rowsPerPage);
	}
	
	/**
	 * @param callable $generator
	 */
	public function addActionGenerator(callable $generator) {
		$this->actionGenerators[] = $generator;
		return $this;
	}
	
	/**
	 * @return bool
	 */
	public function hasActionGenerators() {
		return (\count($this->actionGenerators) > 0);
	}
	
	/**
	 * @return array<callable>
	 */
	public function getActionGenerators() {
		return $this->actionGenerators;
	}
	
	/**
	 * @param string $field
	 * @param callable $translator
	 */
	public function setFieldTranslator($field, callable $translator) {
		$this->fieldTranslators[$field] = $translator;
		return $this;
	}
	
	/**
	 * @param string $field
	 * @return callable
	 */
	public function getFieldTranslator($field) {
		if (isset($this->fieldTranslators[$field])) {
			return $this->fieldTranslators[$field];
		} else {
			return null;
		}
	} 
}
