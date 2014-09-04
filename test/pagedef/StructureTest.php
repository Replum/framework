<?php

namespace nexxes\widgets\pagedef;

use \nexxes\widgets\PageTraitMock;
use \nexxes\widgets\WidgetCompositeTraitMock;
use \nexxes\widgets\WidgetContainerTraitMock;
use \nexxes\widgets\html\Text;

/**
 * @author Dennis Birkholz <dennis.birkholz@nexxes.net>
 * @  coversDefaultClass \nexxes\widgets\pagedef\ArrayImporter
 */
class StructureTest extends \PHPUnit_Framework_TestCase {
	protected function loadInizializer($name, $root) {
		$struct = include(__DIR__ . '/defs/' . \substr($name, 4) . '.php');
		$code = $struct->generateCode(null, [], 'root');
		return eval($code);
	}
	
	/**
	 * Test simple structure
	 * @test
	 */
	public function testSimpleStruct() {
		$page = new PageTraitMock();
		$func = $this->loadInizializer(__FUNCTION__, $page);
		$func($page);
		
		$this->assertCount(1, $page);
		$this->assertInstanceOf(Text::class, $page[0]);
		$this->assertTrue($page[0]->hasClass('testclass'));
		$this->assertEquals('Test Text', $page[0]->getText());
	}
	
	/**
	 * Test simple structure
	 * @test
	 */
	public function testRefStruct() {
		$page = new PageTraitMock();
		$page->testref = '';
		$func = $this->loadInizializer(__FUNCTION__, $page);
		$func($page);
		
		$this->assertSame($page->testref, $page[0]);
	}
	
	/**
	 * Test multiple children
	 * @test
	 */
	public function testMultiChildrenStruct() {
		$page = new PageTraitMock();
		$func = $this->loadInizializer(__FUNCTION__, $page);
		$func($page);
		
		$this->assertCount(3, $page);
		$this->assertTrue($page[0]->hasClass('class1'));
		$this->assertTrue($page[1]->hasClass('class2'));
		$this->assertTrue($page[2]->hasClass('class3'));
	}
	
	/**
	 * Test slot assignments: direct slot assignment and appending to slots containing WidgetContainer
	 * @test
	 */
	public function testSlotsStruct() {
		$root = new WidgetCompositeTraitMock();
		$root->childSlot('slot1');
		$root->childSlot('slot2');
		$root->childSlot('slot3');
		$root['slot3'] = new WidgetContainerTraitMock();
		
		$func = $this->loadInizializer(__FUNCTION__, $root);
		$func($root);
		
		$this->assertTrue($root['slot1']->hasClass('class1'));
		$this->assertTrue($root['slot2']->hasClass('class2'));
		$this->assertTrue($root['slot3'][0]->hasClass('class3'));
		$this->assertTrue($root['slot3'][1]->hasClass('class4'));
	}
	
	/**
	 * @expectedException \Exception
	 * @expectedExceptionMessage No accessible setter
	 */
	public function testInvalidProperty() {
		$root = new Text(new PageTraitMock());
		$struct = (new structure\Widget(Text::class))->add(
			new structure\Property('invalidProperty', 'error')
		);
		
		$code = $struct->generateCode(null, [], 'root');
		$func = eval($code);
		$func($root);
	}
	
}
