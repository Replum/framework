<?php

namespace nexxes\widgets;

class WidgetRegistryTest extends \PHPUnit_Framework_TestCase {
	/**
	 * @covers \nexxes\widgets\WidgetRegistry::register
	 */
	public function testRegister() {
		$w1 = new WidgetTraitMock();
		$w2 = new WidgetTraitMock();
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
	 * @covers \nexxes\widgets\WidgetTrait::getId
	 * @covers \nexxes\widgets\WidgetTrait::setId
	 */
	public function testNotifyIdChange() {
		$page = new PageTraitMock();
		
		$w1 = new WidgetTraitMock();
		$w1->setParent($page);
		
		$r = $page->getWidgetRegistry();
		$r->register($w1);
		
		$oldID = $w1->getID();
		$newID = 'widget1';
		$w1->setID($newID);
		
		$this->assertEquals($newID, $w1->getID());
	}

	/**
	 * @covers \nexxes\widgets\WidgetRegistry::notifyIdChange
	 * @covers \nexxes\widgets\WidgetTrait::getId
	 * @covers \nexxes\widgets\WidgetTrait::setId
	 * @expectedException \Exception
	 */
	public function testNotifyIdChangeDuplicateIdentifier() {
		try {
			$page = new PageTraitMock();
			
			$w1 = (new WidgetTraitMock())->setParent($page);
			$w2 = (new WidgetTraitMock())->setParent($page);

			$r = $page->getWidgetRegistry();
			$r->register($w1);
			$r->register($w2);
			
			$w1->setID('foo');
		} catch (\Exception $e) {
			$this->fail($e->getMessage());
		}
		
		$w1->setID($w2->getID());
	}

	/**
	 * @covers \nexxes\widgets\WidgetRegistry::notifyIdChange
	 */
	public function testNotifyIdChangeNotRegistered() {
		$page = new PageTraitMock();

		$w1 = (new WidgetTraitMock())->setParent($page);
		$w2 = (new WidgetTraitMock())->setParent($page);

		$r = $page->getWidgetRegistry();
		$r->register($w2);

		$w2->setID('widget2');
		
		$w1ID = $w1->getID();
		$w1->setID('widget1');
	}
	
	/**
	 * @covers \nexxes\widgets\WidgetRegistry::getWidget
	 */
	public function testGetWidget() {
		$w = new WidgetTraitMock();
		
		$r = new WidgetRegistry;
		$r->register($w);
		
		$this->assertSame($w, $r->getWidget($w->getID()));
	}
	
	/**
	 * @covers \nexxes\widgets\WidgetRegistry::getWidget
	 * @expectedException \Exception
	 */
	public function testGetWidgetNotFound() {
		$r = new WidgetRegistry;
		$r->getWidget('IllegalWidgetID');
	}
}
