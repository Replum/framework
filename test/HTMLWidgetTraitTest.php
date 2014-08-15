<?php

namespace nexxes\widgets;

/**
 * @coversDefaultClass \nexxes\widgets\HTMLWidgetTrait
 */
class HTMLWidgetTraitTest extends \PHPUnit_Framework_TestCase {
	/**
	 * Helper method to create a new mock
	 * @return \nexxes\widgets\HTMLWidgetTrait
	 */
	private function createMock() {
		$mock = $this->getMockForTrait(HTMLWidgetTrait::class, [], '', true, true, true, ['setChanged']);
		$mock->expects($this->any())
			->method('setChanged')
			->will($this->returnSelf());
		
		return $mock;
	}
	
	/**
	 * @covers ::addClass
	 * @covers ::getClasses
	 */
	public function testAddClass() {
		$mock = $this->createMock();
		
		$mock->addClass('test1');
		$this->assertContains('test1', $mock->getClasses());
		$this->assertCount(1, $mock->getClasses());
		
		$mock->addClass('test2');
		$this->assertContains('test1', $mock->getClasses());
		$this->assertContains('test2', $mock->getClasses());
		$this->assertCount(2, $mock->getClasses());
	}
	
	/**
	 * @covers ::delClass
	 * @covers ::getClasses
	 */
	public function testDelClass() {
		$mock = $this->createMock();
		
		$mock->addClass('test1');
		$mock->addClass('test2');
		$this->assertContains('test1', $mock->getClasses());
		$this->assertContains('test2', $mock->getClasses());
		$this->assertCount(2, $mock->getClasses());
		
		$mock->delClass('test1');
		$this->assertNotContains('test1', $mock->getClasses());
		$this->assertContains('test2', $mock->getClasses());
		$this->assertCount(1, $mock->getClasses());
		
		$mock->delClass('test2');
		$this->assertNotContains('test1', $mock->getClasses());
		$this->assertNotContains('test2', $mock->getClasses());
		$this->assertCount(0, $mock->getClasses());
	}
	
	/**
	 * @covers ::getClassesHTML
	 */
	/* Can not test this private method directly, try it later
	public function testGetClassesHTML() {
		$mock = $this->createMock();
		
		$this->assertSame($mock->getClassesHTML(), '');
		
		$mock->addClass('test2');
		$this->assertSame($mock->getClassesHTML(), ' class="test2"');
		
		$mock->addClass('test1');
		$this->assertSame($mock->getClassesHTML(), ' class="test1 test2"');
		
		$mock->addClass('test3<4');
		$this->assertSame($mock->getClassesHTML(), ' class="test1 test2 test3&lt;4"');
	}*/
}

