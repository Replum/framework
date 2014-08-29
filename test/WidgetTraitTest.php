<?php

namespace nexxes\widgets;

/**
 * @author Dennis Birkholz <dennis.birkholz@nexxes.net>
 * @coversDefaultClass \nexxes\widgets\WidgetTrait
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
	 * @covers ::setTabIndex
	 * @expectedException \Exception
	 */
	public function testSetTabIndexWrongType() {
		$mock = new WidgetTraitMock();
		$mock->setTabIndex("fail");
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
	 * @covers ::setTitle
	 * @expectedException \Exception
	 */
	public function testSetTitleWrongType() {
		$mock = new WidgetTraitMock();
		$mock->setTitle(new \stdClass());
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
	
	/**
	 * @covers ::isRoot
	 */
	public function testIsRoot() {
		// No parent exists, so it is root
		$mock1 = new WidgetTraitMock();
		$this->assertTrue($mock1->isRoot());
		
		// Parent exists, so no root
		$mock2 = new WidgetTraitMock();
		$mock3 = (new WidgetTraitMock())->setParent($mock2);
		$this->assertFalse($mock3->isRoot());
		
		// Page is always root
		$page = new PageTraitMock();
		$this->assertTrue($page->isRoot());
	}
	
	/**
	 * @covers ::getParent
	 * @covers ::setParent
	 */
	public function testGetSetParent() {
		$parent = new WidgetTraitMock();
		
		// Setter must return object
		$child = (new WidgetTraitMock())->setParent($parent);
		$this->assertInstanceOf(WidgetTraitMock::class, $child);
		
		// Verify parent was set
		$this->assertSame($parent, $child->getParent());
		
		// Duplicate set should just return object itself
		$this->assertSame($child, $child->setParent($parent));
		$this->assertSame($parent, $child->getParent());
	}
	
	/**
	 * @covers ::getParent
	 * @expectedException \Exception
	 */
	public function testGetParentNoParentSet() {
		$child = new WidgetTraitMock();
		$child->getParent();
	}
	
	/**
	 * Verify the escape function quotes only what is desired.
	 */
	public function testEscape() {
		$widget = new WidgetTraitMock();
		
		$checkEquals = [
			'SimpleString',
			// don't quote dots
			'Namespace.Class',
			// Allow scripts inside event handlers
			'alert(\'Hello World\');',
		];
		
		foreach ($checkEquals AS $string) {
			$this->assertEquals($string, $widget->publicEscape($string));
		}
		
		$checkQuotes = [
			// No html tag injections
			'<script>unsave()</script>',
			// No break out of double quoted attribute values
			'" inject="',
		];
		
		foreach ($checkQuotes AS $string) {
			$this->assertNotEquals($string, $widget->publicEscape($string));
		}
	}
}
