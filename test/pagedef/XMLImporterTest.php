<?php

namespace nexxes\widgets\pagedef;

use \nexxes\widgets\PageTraitMock;

/**
 * @author Dennis Birkholz <dennis.birkholz@nexxes.net>
 */
class XMLImporterTest extends StructImporterTest {
	protected function loadInizializer($name, $root) {
		$importer = new XMLImporter();
		return $importer->importFile($root, __DIR__ . '/defs/' . \substr($name, 4) . '.xml');
	}
	
	/**
	 * Verify a property always has a name
	 * @test
	 * @expectedException \UnexpectedValueException
	 * @expectedExceptionMessage "name" attribute required
	 */
	public function testPropertyWithoutName() {
		$page = new PageTraitMock();
		$func = $this->loadInizializer(__FUNCTION__, $page);
		$func($page);
	}
	
	/**
	 * Test a property that is itself a Widget
	 * 
	 * @test
	 */
	public function testPropertyIsWidget() {
		$page = new PageTraitMock();
		$func = $this->loadInizializer(__FUNCTION__, $page);
		$func($page);
	}
	
	public function testPropertyWithoutSetterPublic() {
		$page = new PageTraitMock();
		$func = $this->loadInizializer(__FUNCTION__, $page);
		$func($page);
	}
	
	public function testPropertyWithoutSetterProtected() {
		$page = new PageTraitMock();
		$func = $this->loadInizializer(__FUNCTION__, $page);
		$func($page);
	}
	
	public function testPropertyWithoutSetterPrivate() {
		$page = new PageTraitMock();
		$func = $this->loadInizializer(__FUNCTION__, $page);
		$func($page);
	}
}
