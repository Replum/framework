<?php

namespace nexxes\widgets\pagedef;

use \nexxes\widgets\WidgetInterface;

/**
 * @author Dennis Birkholz <dennis.birkholz@nexxes.net>
 */
class StructImporter implements ImporterInterface {
	/**
	 * {@inheritdoc}
	 */
	public function importFile(WidgetInterface $root, $filename) {
		if (!\file_exists($filename) || !\is_readable($filename)) {
			throw new \RuntimeException('Can not open widget structure file "' . $filename . '"');
		}
		
		$data = include($filename);
		return $this->import($root, $data);
	}
	
	/**
	 * {@inheritdoc}
	 */
	public function import(WidgetInterface $root, $struct) {
		$code = $struct->generateCode(null, [], 'root');
		$importer = eval($code);
		return $importer;
	}
}
