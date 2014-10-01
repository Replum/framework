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
}
