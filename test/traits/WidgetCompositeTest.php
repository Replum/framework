<?php

namespace nexxes\widgets\traits;

require_once(__DIR__ . '/WidgetCompositeMock.php');
require_once(__DIR__ . '/../IdentifiableMock.php');

use \nexxes\widgets\IdentifiableMock as WidgetMock;

/**
 * @covers \nexxes\widgets\traits\WidgetComposite
 */
class WidgetCompositeTest extends \PHPUnit_Framework_TestCase {
	public function testValidUsage() {
		$c = new WidgetCompositeMock();
		
		// Check not created slot
		$this->assertFalse(isset($c['test']));
		
		// Create slot, access should return null, not error
		$c->childSlot('test');
		$this->assertNull($c['test']);
		
		// Assign slot, assignment must return assigned widget
		$i1 = new WidgetMock('id1');
		$i2 = ($c['test'] = $i1);
		
		$this->assertTrue(isset($c['test']));
		$this->assertSame($i1, $c['test']);
		$this->assertSame(1, count($c));
		$this->assertSame($i1, $i2);
		
		// Assign same widget again, nothing is done but same widget should be returned again
		$i2 = ($c['test'] = $i1);
		$this->assertSame($i1, $i2);
		
		// Empty filled slot
		unset($c['test']);
		$this->assertFalse(isset($c['test']));
		$this->assertSame(0, count($c));
		
		// Unset already empty slot
		unset($c['test']);
	}
	
	public function testIterator() {
		$c = new WidgetCompositeMock();
		$ref = [];
		$count = 5;
		
		for ($i=1; $i<=$count; $i++) {
			$n = 'test' . $i;
			$c->childSlot($n);
			
			$ref[$n] = new WidgetMock($n);
			$c[$n] = $ref[$n];
			$this->assertSame($ref[$n], $c[$n]);
		}
		$this->assertSame($count, \count($c));
		
		foreach ($c AS $key => $value) {
			$this->assertTrue(isset($ref[$key]));
			$this->assertSame($ref[$key], $value);
			unset($ref[$key]);
		}
		$this->assertSame($ref, []);
	}
	
	/**
	 * @expectedException \InvalidArgumentException
	 */
	public function testGetInvalidSlot() {
		$c = new WidgetCompositeMock();
		echo $c['test'];
	}
	
	/**
	 * @expectedException \InvalidArgumentException
	 */
	public function testSetInvalidSlot() {
		$c = new WidgetCompositeMock();
		$c['test'] = new WidgetMock('id1');
	}
	
	/**
	 * @expectedException \InvalidArgumentException
	 */
	public function testSetInvalidClass() {
		$c = new WidgetCompositeMock();
		$c->childSlot('test', [\stdClass::class]);
		$c['test'] = new WidgetMock('id1');
	}
	
	/**
	 * @expectedException \InvalidArgumentException
	 */
	public function unsetInvalidSlot() {
		$c = new WidgetCompositeMock();
		unset($c['test']);
	}
}
