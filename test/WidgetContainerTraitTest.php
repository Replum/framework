<?php

namespace nexxes\widgets;

/**
 * @coversDefaultClass WidgetContainerTrait
 */
class WidgetContainerTraitTest extends \PHPUnit_Framework_TestCase {
	public function testGetSet() {
		$page = new PageTraitMock();
		$container = new WidgetContainerTraitMock($page);
		$children = $container->children();
		 
		$i0 = $this->getMock(WidgetInterface::class);
		//$i0->setID('id0');
		$children[] = $i0;
		$this->assertSame($i0, $children[0]);
		$this->assertTrue(isset($children[0]));
		$this->assertFalse(isset($children[1]));
		
		$i1 = $this->getMock(WidgetInterface::class);
		//$i1->setID('id1');
		$children[] = $i1;
		$this->assertSame($i1, $children[1]);
		$this->assertTrue($children->contains($i1));
		
		$i2 = $this->getMock(WidgetInterface::class);
		//$i2->setID('id2');
		$children[] = $i2;
		$this->assertSame($i2, $children[2]);
		$this->assertTrue($children->contains($i2));
		
		$this->assertSame(3, \count($children));
		
		$i3 = $this->getMock(WidgetInterface::class);
		//$i3->setID('id3');
		$children[1] = $i3;
		$this->assertSame($i3, $children[1]);
		$this->assertFalse($children->contains($i1));
		$this->assertTrue($children->contains($i3));
		
		$this->assertSame(\count($children), 3);
		
		unset($children[0]);
		$this->assertSame(2, \count($children));
		$this->assertSame($i3, $children[0]);
		$this->assertSame($i2, $children[1]);
	}
	
	public function testIterator() {
		$num = 7;
		
		$page = new PageTraitMock();
		$container = new WidgetContainerTraitMock($page);
		$children = $container->children();
		
		for ($i=0; $i<$num; $i++) {
			$children[] = $this->getMock(WidgetInterface::class);
		}
		
		$count = 0;
		foreach ($children AS $elem) {
			$count++;
		}
		
		$this->assertSame($num, $count);
		$this->assertSame($num, \count($children));
	}
	
	/**
	 * @expectedException \Exception
	 */
	public function testNotAllowedClass() {
		$page = new PageTraitMock();
		$container = new WidgetContainerTraitMock($page);
		$children = $container->children();
		
		$children[] = new \stdClass();
	}
	
	/**
	 * Verify the same object is only added once to the container
	 */
	public function testAddSameObject() {
		$page = new PageTraitMock();
		$container = new WidgetContainerTraitMock($page);
		$children = $container->children();
		
		$mock = $this->getMock(WidgetInterface::class);
		$children[] = $mock;
		$children[] = $mock;
		
		$this->assertCount(1, $children);
	}
}
