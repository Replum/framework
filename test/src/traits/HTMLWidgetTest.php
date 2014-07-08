<?php

namespace nexxes\widgets\traits;

require_once(__DIR__ . '/HTMLWidgetMock.php');

class HTMLWidgetTest extends \PHPUnit_Framework_TestCase {
	public function testAddClass() {
		$w = new HTMLWidgetMock();
		
		$w->addClass('test1');
		$this->assertContains('test1', $w->getClasses());
		$this->assertCount(1, $w->getClasses());
		
		$w->addClass('test2');
		$this->assertContains('test1', $w->getClasses());
		$this->assertContains('test2', $w->getClasses());
		$this->assertCount(2, $w->getClasses());
	}
	
	public function testDelClass() {
		$w = new HTMLWidgetMock();
		$w->addClass('test1');
		$w->addClass('test2');
		$this->assertContains('test1', $w->getClasses());
		$this->assertContains('test2', $w->getClasses());
		$this->assertCount(2, $w->getClasses());
		
		$w->delClass('test1');
		$this->assertNotContains('test1', $w->getClasses());
		$this->assertContains('test2', $w->getClasses());
		$this->assertCount(1, $w->getClasses());
		
		$w->delClass('test2');
		$this->assertNotContains('test1', $w->getClasses());
		$this->assertNotContains('test2', $w->getClasses());
		$this->assertCount(0, $w->getClasses());
	}
	
	public function testGetClassesHTML() {
		$w = new HTMLWidgetMock();
		
		$this->assertSame($w->getClassesHTML(), '');
		
		$w->addClass('test2');
		$this->assertSame($w->getClassesHTML(), ' class="test2"');
		
		$w->addClass('test1');
		$this->assertSame($w->getClassesHTML(), ' class="test1 test2"');
		
		$w->addClass('test3<4');
		$this->assertSame($w->getClassesHTML(), ' class="test1 test2 test3&lt;4"');
	}
}

