<?php

namespace nexxes\widgets;

/**
 * @coversDefaultClass \nexxes\widgets\WidgetCompositeTrait
 */
class WidgetCompositeTest extends \PHPUnit_Framework_TestCase {
	public function testValidUsage() {
		$composite = new WidgetCompositeTraitMock();
		
		// Check not created slot
		$this->assertFalse(isset($composite['test']));
		
		// Create slot, access should return null, not error
		$composite->childSlot('test');
		$this->assertNull($composite['test']);
		
		// Assign slot, assignment must return assigned widget
		$widget = $this->getMock(WidgetInterface::class);
		$probe1 = ($composite['test'] = $widget);
		$this->assertSame($widget, $probe1);
		
		$this->assertTrue(isset($composite['test']));
		$this->assertSame($widget, $composite['test']);
		$this->assertSame(1, count($composite));
		
		// Assign same widget again, nothing is done but same widget should be returned again
		$probe2 = ($composite['test'] = $widget);
		$this->assertSame($widget, $probe2);
		
		// Empty filled slot
		unset($composite['test']);
		$this->assertFalse(isset($composite['test']));
		$this->assertSame(0, count($composite));
		
		// Unset already empty slot
		unset($composite['test']);
	}
	
	public function testIterator() {
		$composite = new WidgetCompositeTraitMock();
		$ref = [];
		$count = 5;
		
		for ($i=1; $i<=$count; $i++) {
			$n = 'test' . $i;
			$composite->childSlot($n);
			
			$ref[$n] = $this->getMock(WidgetInterface::class);
			$composite[$n] = $ref[$n];
			$this->assertSame($ref[$n], $composite[$n]);
		}
		$this->assertSame($count, \count($composite));
		
		foreach ($composite AS $key => $value) {
			$this->assertTrue(isset($ref[$key]));
			$this->assertSame($ref[$key], $value);
			unset($ref[$key]);
		}
		$this->assertSame($ref, []);
	}
	
	/**
	 * @expectedException \InvalidArgumentException
	 * @covers ::offsetGet
	 */
	public function testGetInvalidSlot() {
		$composite = new WidgetCompositeTraitMock();
		echo $composite['test'];
	}
	
	/**
	 * @expectedException \InvalidArgumentException
	 * @covers ::offsetSet
	 */
	public function testSetInvalidSlot() {
		$composite = new WidgetCompositeTraitMock();
		$composite['test'] = $this->getMock(WidgetInterface::class);
	}
	
	/**
	 * @expectedException \InvalidArgumentException
	 * @covers ::offsetSet
	 */
	public function testSetInvalidClass() {
		$composite = new WidgetCompositeTraitMock();
		$composite->childSlot('test', [\stdClass::class]);
		$composite['test'] = $this->getMock(WidgetInterface::class);
	}
	
	/**
	 * @expectedException \InvalidArgumentException
	 * @covers ::offsetUnset
	 */
	public function unsetInvalidSlot() {
		$composite = new WidgetCompositeTraitMock();
		unset($composite['test']);
	}
}

class WidgetCompositeTraitMock implements WidgetCompositeInterface {
	use WidgetCompositeTrait;
	
	public function __toString() {
	}

	public function getPage() {
	}

	public function getParent() {
	}

	public function isChanged() {
	}

	public function isRoot() {
	}

	public function setChanged($changed = true) {
	}

	public function setParent(WidgetInterface $newParent) {
	}
}
