<?php

namespace nexxes\widgets;

use \nexxes\dependency\Gateway as dep;
use \nexxes\widgets\WidgetRegistry;

/**
 * @coversDefaultClass \nexxes\widgets\IdentifiableTrait
 */
class IdentifiableTraitTest extends \PHPUnit_Framework_TestCase {
	/**
	 * Helper method to create a new mock
	 * @return \nexxes\widgets\HTMLWidgetTrait
	 */
	private function createMock() {
		$mock = $this->getMockForTrait(IdentifiableTrait::class, [], '', true, true, true, ['setChanged']);
		$mock->expects($this->any())
			->method('setChanged')
			->will($this->returnSelf());
		
		return $mock;
	}
	
	protected function setUp() {
		$registry = $this->getMock(\stdClass::class, ['notifyIdChange']);
		$registry->expects($this->any())
			->method('notifyIdChange')
			->willReturn(true);
		
		dep::registerObject(WidgetRegistry::class, $registry);
	}

	/**
	 * @covers ::getID
	 * @covers ::setID
	 */
	public function testGetSetID() {
		$mock = $this->createMock();
		$mock->setID('abc');
		
		$oldID = $mock->getID();
		$newID = 'widget1';
		$this->assertNotEquals($newID, $oldID);
		
		$mock->setID($newID);
		$this->assertEquals($mock->getID(), $newID);
	}
}

