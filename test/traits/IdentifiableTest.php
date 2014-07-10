<?php

namespace nexxes\widgets\traits;

use \nexxes\dependency\Gateway as dep;
use \nexxes\widgets\WidgetRegistry;

require_once(__DIR__ . '/IdentifiableMock.php');

class IdentifiableTest extends \PHPUnit_Framework_TestCase {
	protected function setUp() {
		dep::registerObject(WidgetRegistry::class, new WidgetRegistry);
	}

	/**
	 * @covers nexxes\widgets\traits\Identifiable::getID
	 */
	public function testGetID() {
	}

	/**
	 * @covers nexxes\widgets\traits\Identifiable::setID
	 */
	public function testSetID() {
		$w = new IdentifiableMock;
		
		/* @var $r \nexxes\widgets\WidgetRegistry */
		$r = dep::get(WidgetRegistry::class);
		$r->register($w);
		
		$oldID = $w->getID();
		$newID = 'widget1';
		$this->assertNotEquals($newID, $oldID);
		
		$w->setID($newID);
		$this->assertEquals($w->getID(), $newID);
		$this->assertSame($r->getWidget($newID), $w);
	}
}

