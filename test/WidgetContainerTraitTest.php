<?php

namespace nexxes\widgets;

/**
 * @coversDefaultClass WidgetContainerTrait
 */
class WidgetContainerTraitTest extends \PHPUnit_Framework_TestCase {
	public function testGetSet() {
		$l = new WidgetContainerTraitMock;
		
		$i0 = $this->getMock(WidgetInterface::class);
		//$i0->setID('id0');
		$l[] = $i0;
		$this->assertSame($i0, $l[0]);
		$this->assertTrue(isset($l[0]));
		$this->assertFalse(isset($l[1]));
		
		$i1 = $this->getMock(WidgetInterface::class);
		//$i1->setID('id1');
		$l[] = $i1;
		$this->assertSame($i1, $l[1]);
		$this->assertTrue($l->hasChild($i1));
		
		$i2 = $this->getMock(WidgetInterface::class);
		//$i2->setID('id2');
		$l[] = $i2;
		$this->assertSame($i2, $l[2]);
		$this->assertTrue($l->hasChild($i2));
		
		$this->assertSame(3, \count($l));
		
		$i3 = $this->getMock(WidgetInterface::class);
		//$i3->setID('id3');
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
		
		$l = new WidgetContainerTraitMock;
		
		for ($i=0; $i<$num; $i++) {
			$l[] = $this->getMock(WidgetInterface::class);
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
		$l = new WidgetContainerTraitMock;
		$l[] = new \stdClass();
	}
	
	/**
	 * @expectedException \InvalidArgumentException
	 */
	public function testReadIllegalOffset() {
		$l = new WidgetContainerTraitMock;
		
		$l[] = $this->getMock(WidgetInterface::class);
		echo $l[2];
	}
	
	/**
	 * @expectedException \InvalidArgumentException
	 */
	public function testSetIllegalOffsetString() {
		$l = new WidgetContainerTraitMock;
		
		// This does not trigger the exception as it seems to be auto-converted to an integer before the offsetSet method is called
		//$l["0"] = new WidgetMock();
		
		$i = "0";
		$l[$i] = $this->getMock(WidgetInterface::class);
	}
	
	/**
	 * @expectedException \InvalidArgumentException
	 */
	public function testSetIllegalOffsetNegative() {
		$l = new WidgetContainerTraitMock;
		$l[-1] = $this->getMock(WidgetInterface::class);
	}
	
	/**
	 * @expectedException \InvalidArgumentException
	 */
	public function testSetIllegalOffsetSparse() {
		$l = new WidgetContainerTraitMock;
		$l[100] = $this->getMock(WidgetInterface::class);
	}
	
	/**
	 * @expectedException \InvalidArgumentException
	 */
	public function testUnsetIllegalOffset() {
		$l = new WidgetContainerTraitMock;
		$l[] = $this->getMock(WidgetInterface::class);
		unset($l[2]);
	}
}
