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
class StructImporterTest extends \PHPUnit_Framework_TestCase {
	protected function loadInizializer($name, $root) {
		$importer = new StructImporter();
		return $importer->importFile($root, __DIR__ . '/defs/' . \substr($name, 4) . '.php');
	}
	
	/**
	 * Test simple structure
	 * @test
	 */
	public function testSimpleStruct() {
		$page = new PageTraitMock();
		$func = $this->loadInizializer(__FUNCTION__, $page);
		$func($page);
		
		$this->assertCount(1, $page->children());
		$this->assertInstanceOf(Text::class, $page->children()[0]);
		$this->assertTrue($page->children()[0]->hasClass('testclass'));
		$this->assertEquals('Test Text', $page->children()[0]->getText());
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
		
		$this->assertSame($page->testref, $page->children()[0]);
	}
	
	/**
	 * Test multiple children
	 * @test
	 */
	public function testMultiChildrenStruct() {
		$page = new PageTraitMock();
		$func = $this->loadInizializer(__FUNCTION__, $page);
		$func($page);
		
		$this->assertCount(3, $page->children());
		$this->assertTrue($page->children()[0]->hasClass('class1'));
		$this->assertTrue($page->children()[1]->hasClass('class2'));
		$this->assertTrue($page->children()[2]->hasClass('class3'));
	}
	
	/**
	 * Test slot assignments: direct slot assignment and appending to slots containing WidgetContainer
	 * @test
	 */
	public function testSlotsStruct() {
		$page = new PageTraitMock();
		
		$root = new WidgetCompositeTraitMock($page);
		$root->childSlot('slot1');
		$root->childSlot('slot2');
		$root->childSlot('slot3');
		$root['slot3'] = new WidgetContainerTraitMock($root);
		
		$func = $this->loadInizializer(__FUNCTION__, $root);
		$func($root);
		
		$this->assertTrue($root['slot1']->hasClass('class1'));
		$this->assertTrue($root['slot2']->hasClass('class2'));
		$this->assertTrue($root['slot3']->children()[0]->hasClass('class3'));
		$this->assertTrue($root['slot3']->children()[1]->hasClass('class4'));
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
