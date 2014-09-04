<?php

namespace nexxes\widgets\pagedef;

/**
 * @author Dennis Birkholz <dennis.birkholz@nexxes.net>
 */
class XMLImporterTest extends StructImporterTest {
	protected function loadInizializer($name, $root) {
		$importer = new XMLImporter();
		return $importer->importFile($root, __DIR__ . '/defs/' . \substr($name, 4) . '.xml');
	}
}
