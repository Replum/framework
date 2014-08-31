<?php

namespace nexxes\widgets\pagedef;

/**
 * The Initializer creates the widgets according to a (cached) page structure definition.
 * 
 *
 * @author Dennis Birkholz <dennis.birkholz@nexxes.net>
 */
class Initializer {
	/**
	 * Directory containing cached page definitions
	 * @var string
	 */
	private $cacheDir;
	
	/**
	 * List of namespaces to search classes in to create widgets
	 * @var array<string>
	 */
	private $namespaces = [
		'\\nexxes\\widgets\\bootstrap',
		'\\nexxes\\widgets\\html',
		'\\nexxes\\widgets',
	];
	
	
	
	
	/**
	 * @param array<string> $additionalNamespaces
	 * @param string $cacheDir
	 */
	public function __construct($additionalNamespaces = [], $cacheDir = '/tmp') {
		$this->namespaces = \array_merge($additionalNamespaces, $this->namespaces);
		$this->cacheDir = $cacheDir;
	}
	
	/**
	 * @param \nexxes\widgets\PageInterface $page
	 */
	public function run(\nexxes\widgets\PageInterface $page) {
		$reflectionClass = new \ReflectionClass($page);
		
		// Remove .php from the end
		$scriptFile = $reflectionClass->getFileName();
		$defFile = \substr($scriptFile, 0, \strlen($scriptFile)-4);
		
		$arrayImporter = new ArrayImporter($this->namespaces);
		
		if (\file_exists($defFile . '.xml')) {
			$xmlImporter = new XMLImporter($arrayImporter);
			$phpCode = $xmlImporter->importFile($page, $defFile . '.xml');
		}
		
		elseif (\file_exists($defFile . '.struct.php')) {
			$phpCode = $arrayImporter->importFile($page, $defFile . '.struct.php');
		}
		
		else {
			throw new \InvalidArgumentException('Can not initialize widgets for page "' . \get_class($page) . '"');
		}
		
		echo '<pre>' . $phpCode . '</pre><br>' . PHP_EOL;
		
		$initializer = eval($phpCode);
		$initializer($page);
	}
}
