<?php

namespace nexxes\widgets\pagedef;

/**
 * @author Dennis Birkholz <dennis.birkholz@nexxes.net>
 */
class XMLImporterTest extends StructureTest {
	protected function loadInizializer($name, $root) {
		$importer = new XMLImporter();
		$code = $importer->importFile($root, __DIR__ . '/defs/' . \substr($name, 4) . '.xml');
		return eval($code);
	}
}
