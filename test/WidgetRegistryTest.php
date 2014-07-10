<?php

namespace nexxes\widgets;

require_once(__DIR__ . '/IdentifiableMock.php');

/**
 * Generated by PHPUnit_SkeletonGenerator 1.2.1 on 2014-07-06 at 13:47:11.
 */
class WidgetRegistryTest extends \PHPUnit_Framework_TestCase {

	/**
	 * @var WidgetRegistry
	 */
	protected $object;

	/**
	 * Sets up the fixture, for example, opens a network connection.
	 * This method is called before a test is executed.
	 */
	protected function setUp() {
		$this->object = new WidgetRegistry;
	}

	/**
	 * Tears down the fixture, for example, closes a network connection.
	 * This method is called after a test is executed.
	 */
	protected function tearDown() {
		
	}

	/**
	 * @covers \nexxes\widgets\WidgetRegistry::initWidgets
	 * @todo   Implement testInitWidgets().
	 */
	public function testInitWidgets() {
		// Remove the following lines when you implement this test.
		$this->markTestIncomplete(
						'This test has not been implemented yet.'
		);
	}

	/**
	 * @covers \nexxes\widgets\WidgetRegistry::register
	 */
	public function testRegister() {
		$w1 = new IdentifiableMock();
		$w2 = new IdentifiableMock();
		$this->assertNotSame($w2, $w1);
		
		$r = new WidgetRegistry;
		$r->register($w1);
		$r->register($w2);
		
		$this->assertNotNull($w1->getID());
		$this->assertSame($w1, $r->getWidget($w1->getID()));
		$this->assertNotNull($w2->getID());
		$this->assertSame($w2, $r->getWidget($w2->getID()));
		$this->assertNotEquals($w1->getID(), $w2->getID());
	}

	/**
	 * @covers \nexxes\widgets\WidgetRegistry::notifyIdChange
	 */
	public function testNotifyIdChange() {
		$w1 = new IdentifiableMock();
		
		$r = new WidgetRegistry;
		$r->register($w1);
		
		$oldID = $w1->getID();
		$newID = 'widget1';
		$w1->setID($newID);
		
		$this->assertEquals($w1->getID(), $newID);
		
		$this->assertEquals($r->getWidget($oldID)->getID(), $newID);
		$r->notifyIdChange($w1);
		
		$this->assertEquals($r->getWidget($newID)->getID(), $newID);
	}

	/**
	 * @covers \nexxes\widgets\WidgetRegistry::notifyIdChange
	 * @expectedException \Exception
	 */
	public function testNotifyIdChange_DuplicateIdentifier() {
		$w1 = new IdentifiableMock();
		$w2 = new IdentifiableMock();
		
		$r = new WidgetRegistry;
		$r->register($w1);
		$r->register($w2);
		
		$w1->setID($w2->getID());
		$r->notifyIdChange($w1);
	}

	/**
	 * @covers \nexxes\widgets\WidgetRegistry::notifyIdChange
	 * @expectedException \Exception
	 */
	public function testNotifyIdChange_NotRegistered() {
		$w1 = new IdentifiableMock();
		$w2 = new IdentifiableMock();
		
		$r = new WidgetRegistry;
		$r->register($w2);
		
		$w1->setID($w2->getID());
		$r->notifyIdChange($w1);
	}
	
	/**
	 * @covers \nexxes\widgets\WidgetRegistry::getWidget
	 */
	public function testGetWidget() {
		$w = new IdentifiableMock();
		
		$r = new WidgetRegistry;
		$r->register($w);
		
		$this->assertSame($w, $r->getWidget($w->getID()));
	}
	
	/**
	 * @covers \nexxes\widgets\WidgetRegistry::getWidget
	 * @expectedException \Exception
	 */
	public function testGetWidget_NotFound() {
		$r = new WidgetRegistry;
		$r->getWidget('IllegalWidgetID');
	}

	/**
	 * @covers \nexxes\widgets\WidgetRegistry::getParent
	 * @todo   Implement testGetParent().
	 */
	public function testGetParent() {
		// Remove the following lines when you implement this test.
		$this->markTestIncomplete(
						'This test has not been implemented yet.'
		);
	}

	/**
	 * @covers \nexxes\widgets\WidgetRegistry::setParent
	 * @todo   Implement testSetParent().
	 */
	public function testSetParent() {
		// Remove the following lines when you implement this test.
		$this->markTestIncomplete(
						'This test has not been implemented yet.'
		);
	}

	/**
	 * @covers \nexxes\widgets\WidgetRegistry::persist
	 * @todo   Implement testPersist().
	 */
	public function testPersist() {
		// Remove the following lines when you implement this test.
		$this->markTestIncomplete(
						'This test has not been implemented yet.'
		);
	}

	/**
	 * @covers \nexxes\widgets\WidgetRegistry::restore
	 * @todo   Implement testRestore().
	 */
	public function testRestore() {
		// Remove the following lines when you implement this test.
		$this->markTestIncomplete(
						'This test has not been implemented yet.'
		);
	}

}