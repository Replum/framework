<?php

namespace nexxes\widgets;

class WidgetMock implements WidgetInterface {
	// interface Widget
	
	public function isRoot() {
	}
	
	public function getParent() {
	}
	
	public function setParent(WidgetInterface $newParent) {
	}
	
	public function getPage() {
	}
	
	public function isChanged() {
	}
	
	public function setChanged($changed = true) {
	}
	
	public function __toString() {
	}
	
	
	
	
	const VALIDATOR_APPEND = '_foobar_validator';
	
	public function __construct($id) {
		$this->id = $id;
	}
	
	public $id;
	
	/**
	 * Value of the $value parameter supplied for the last setter call
	 * @var type 
	 */
	public $setterParameter = null;
	
	/**
	 * Value of the $value parameter supplied for the last validator call
	 * @var type 
	 */
	public $validatorParameter = null;
	
	/**
	 * Counts how many times setter() got executed
	 * @var int
	 */
	public $setterCount = 0;
	
	/**
	 * Counts how many times validator() got executed
	 * @var int
	 */
	public $validatorCount = 0;
	
	public function setter($value) {
		$this->setterCount++;
		$this->setterParameter = $value;
		return $value;
	}
	
	public function validator($value) {
		$this->validatorCount++;
		$this->validatorParameter = $value;
		return $value . self::VALIDATOR_APPEND;
	}
}


class ParameterRegistryTest extends \PHPUnit_Framework_TestCase {
	/**
	 * Test registration works and set callback is called
	 */
	public function testImportSetter() {
		$r = new ParameterRegistry;
		$m1 = new WidgetMock('Mock1.id');
		
		$r->register('test', $m1, [$m1, 'setter']);
		$r->import(['test' => 'foobar']);
		
		$this->assertEquals($m1->setterParameter, 'foobar');
	}
	
	/**
	 * Test registration works, validator callback is executed and return value is passed to setter
	 */
	public function testImportValidator() {
		$r = new ParameterRegistry;
		$m1 = new WidgetMock('Mock1.id');
		
		$r->register('test', $m1, [$m1, 'setter'], [$m1, 'validator']);
		$r->import(['test' => 'foobar']);
		
		$this->assertEquals($m1->validatorParameter, 'foobar');
		$this->assertEquals($m1->setterParameter, 'foobar' . WidgetMock::VALIDATOR_APPEND);
	}
	
	/**
	 * Test only registered request vars are used
	 */
	public function testImport() {
		$r = new ParameterRegistry;
		
		$m1 = new WidgetMock('Mock1.id');
		$r->register('test1', $m1, [$m1, 'setter']);
		$r->register('test2', $m1, [$m1, 'setter']);
		
		$m2 = new WidgetMock('Mock2.id');
		$r->register('test3', $m2, [$m2, 'setter'], [$m2, 'validator']);
		
		$data = [
			'test0' => 'foo',
			'test1' => 'bar',
			'test2' => 'baz',
			'test3' => 'blubb',
			'test4' => 'sub',
		];
		
		$r->import($data);
		
		$this->assertEquals($m1->validatorParameter, null, true);
		$this->assertEquals($m1->validatorCount, 0, true);
		
		$this->assertEquals($m1->setterParameter, $data['test2']);
		$this->assertEquals($m1->setterCount, 2, true);

		$this->assertEquals($m2->validatorParameter, $data['test3']);
		$this->assertEquals($m2->validatorCount, 1, true);
		
		$this->assertEquals($m2->setterParameter, $data['test3'] . WidgetMock::VALIDATOR_APPEND);
		$this->assertEquals($m2->setterCount, 1, true);
	}
	
	/**
	 * Verify no two widgets can register for the same request variabel
	 * 
	 * @expectedException \Exception
	 */
	public function testRegisterDuplicateRegistration() {
		$r = new ParameterRegistry;
		
		$m1 = new WidgetMock('Mock1.id');
		$m2 = new WidgetMock('Mock2.id');
		
		$r->register('test', $m1, function() {});
		$r->register('test', $m2, function() {});
	}
	
	/**
	 * Verify unregistering works and only remaining widgets are called
	 */
	public function testUnregister() {
		$r = new ParameterRegistry;
		
		$m1 = new WidgetMock('Mock1.id');
		$r->register('test1', $m1, [$m1, 'setter']);
		
		$m2 = new WidgetMock('Mock2.id');
		$r->register('test2', $m2, [$m2, 'setter']);
		
		$r->unregister($m1);
		$r->import(['test1' => 'foo', 'test2' => 'bar',]);
		
		$this->assertEquals($m1->setterCount, 0, true);
		$this->assertEquals($m2->setterCount, 1, true);
	}
}
