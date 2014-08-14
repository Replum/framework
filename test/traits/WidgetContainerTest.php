<?php

namespace nexxes\widgets\traits;

require_once(__DIR__ . '/WidgetContainerMock.php');
require_once(__DIR__ . '/../IdentifiableMock.php');

use \nexxes\widgets\IdentifiableMock AS WidgetMock;

/**
 * 
 */
class WidgetContainerTest extends \PHPUnit_Framework_TestCase {
	public function testGetSet() {
		$l = new WidgetContainerMock;
		
		$i0 = new WidgetMock();
		$i0->setID('id0');
		$l[] = $i0;
		$this->assertSame($i0, $l[0]);
		$this->assertTrue(isset($l[0]));
		$this->assertFalse(isset($l[1]));
		
		$i1 = new WidgetMock();
		$i1->setID('id1');
		$l[] = $i1;
		$this->assertSame($i1, $l[1]);
		$this->assertTrue($l->hasChild($i1));
		
		$i2 = new WidgetMock();
		$i2->setID('id2');
		$l[] = $i2;
		$this->assertSame($i2, $l[2]);
		$this->assertTrue($l->hasChild($i2));
		
		$this->assertSame(3, \count($l));
		
		$i3 = new WidgetMock();
		$i3->setID('id3');
		$l[1] = $i3;
		$this->assertSame($i3, $l[1]);
		$this->assertFalse($l->hasChild($i1));
		$this->assertTrue($l->hasChild($i3));
		
		$this->assertSame(\count($l), 3);
		
		unset($l[0]);
		$this->assertSame(2, \count($l));
		$this->assertSame($i3, $l[0]);
		$this->assertSame($i2, $l[1]);
	}
	
	public function testIterator() {
		$num = 7;
		
		$l = new WidgetContainerMock;
		
		for ($i=0; $i<$num; $i++) {
			$l[] = new WidgetMock();
		}
		
		$count = 0;
		foreach ($l AS $elem) {
			$count++;
		}
		
		$this->assertSame($num, $count);
		$this->assertSame($num, \count($l));
	}
	
	/**
	 * @expectedException \InvalidArgumentException
	 */
	public function testNotAllowedClass() {
		$l = new WidgetContainerMock;
		$l[] = new \stdClass();
	}
	
	/**
	 * @expectedException \InvalidArgumentException
	 */
	public function testReadIllegalOffset() {
		$l = new WidgetContainerMock;
		
		$l[] = new WidgetMock();
		echo $l[2];
	}
	
	/**
	 * @expectedException \InvalidArgumentException
	 */
	public function testSetIllegalOffsetString() {
		$l = new WidgetContainerMock;
		
		// This does not trigger the exception as it seems to be auto-converted to an integer before the offsetSet method is called
		//$l["0"] = new WidgetMock();
		
		$i = "0";
		$l[$i] = new WidgetMock();
	}
	
	/**
	 * @expectedException \InvalidArgumentException
	 */
	public function testSetIllegalOffsetNegative() {
		$l = new WidgetContainerMock;
		$l[-1] = new WidgetMock();
	}
	
	/**
	 * @expectedException \InvalidArgumentException
	 */
	public function testSetIllegalOffsetSparse() {
		$l = new WidgetContainerMock;
		$l[100] = new WidgetMock();
	}
	
	/**
	 * @expectedException \InvalidArgumentException
	 */
	public function testUnsetIllegalOffset() {
		$l = new WidgetContainerMock;
		$l[] = new WidgetMock();
		unset($l[2]);
	}
}
