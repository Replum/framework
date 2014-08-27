<?php

namespace nexxes\widgets;

/**
 * @author Dennis Birkholz <dennis.birkholz@nexxes.net>
 */
class WidgetTraitTest extends \PHPUnit_Framework_TestCase {
	/**
	 * @covers ::addClass
	 * @covers ::getClasses
	 */
	public function testAddClass() {
		$mock = new WidgetTraitMock();
		
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
		$mock = new WidgetTraitMock();
		
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
	 * @covers ::delClass
	 */
	public function testDelClassRegex() {
		$class1 = 'test-foo';
		$class2 = 'test-bar';
		$class3 = 'est-foo';
		
		$mock = new WidgetTraitMock();
		$mock->addClass($class1);
		$mock->addClass($class2);
		$mock->addClass($class3);
		$this->assertCount(3, $mock->getClasses());
		
		$mock->delClass('/^test-.*/', true);
		$this->assertCount(1, $mock->getClasses());
		
		$this->assertFalse($mock->hasClass($class1));
		$this->assertFalse($mock->hasClass($class2));
		$this->assertTrue($mock->hasClass($class3));
	}
	
	/**
	 * @covers ::hasClass
	 */
	public function testHasClass() {
		$class1 = 'test-foo';
		$class2 = 'test-bar';
		$class3 = 'bar-foo';
		
		$mock = new WidgetTraitMock();
		$this->assertFalse($mock->hasClass($class1));
		
		$mock->addClass($class1);
		$this->assertTrue($mock->hasClass($class1));
		
		$mock->addClass($class2);
		$this->assertTrue($mock->hasClass($class2));
		
		$this->assertTrue($mock->hasClass('/^test-/', true));
		$this->assertFalse($mock->hasClass('/^bar-/', true));
		
		$mock->addClass($class3);
		$this->assertTrue($mock->hasClass($class3));
		$this->assertTrue($mock->hasClass('/^bar-/', true));
	}
	
	/**
	 * @covers ::getClasses
	 */
	public function testGetClasses() {
		$class1 = 'test-foo';
		$class2 = 'test-bar';
		$class3 = 'bar-foo';
		
		$mock = new WidgetTraitMock();
		$mock->addClass($class1);
		$mock->addClass($class2);
		$mock->addClass($class3);
		$this->assertCount(3, $mock->getClasses());
		$this->assertCount(1, $mock->getClasses('/^bar-/', true));
		$this->assertCount(2, $mock->getClasses('/^test-/', true));
	}
	
	/**
	 * @covers ::getTabIndex
	 * @covers ::setTabIndex
	 */
	public function testGetSetTabIndex() {
		$tabindex1 = 10;
		$tabindex2 = 5000;
		
		$mock = new WidgetTraitMock();
		
		$mock->setTabIndex($tabindex1);
		$this->assertEquals($tabindex1, $mock->getTabIndex());
		
		$mock->setTabIndex($tabindex2);
		$this->assertEquals($tabindex2, $mock->getTabIndex());
		$mock->setTabIndex($tabindex2);
		$this->assertEquals($tabindex2, $mock->getTabIndex());
	}
	
	/**
	 * @covers ::getTitle
	 * @covers ::setTitle
	 */
	public function testGetSetTitle() {
		$title1 = 'TestTitle';
		$title2 = 'AnotherTestTitle';
		
		$mock = new WidgetTraitMock();
		
		$mock->setTitle($title1);
		$this->assertEquals($title1, $mock->getTitle());
		
		$mock->setTitle($title2);
		$this->assertEquals($title2, $mock->getTitle());
		$mock->setTitle($title2);
		$this->assertEquals($title2, $mock->getTitle());
	}
	
	/**
	 * @covers ::getID
	 * @covers ::setID
	 */
	public function testGetSetID() {
		$id1 = 'widgetId1';
		$id2 = 'widgetId2';
		
		$mock = new WidgetTraitMock();
		
		$mock->setID($id1, true);
		$this->assertEquals($id1, $mock->getID());
		
		$mock->setID($id2, true);
		$this->assertEquals($id2, $mock->getID());
	}
}
