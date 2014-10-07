<?php

if (false !== ($autoloaders = \spl_autoload_functions())) {
	foreach ($autoloaders as $a) {
		if (
			\is_array($a)
			&& isset($a[0])
			&& \is_object($a[0])
			&& (\get_class($a[0]) === 'Composer\\Autoload\\ClassLoader')
		) {
			$autoloader = $a;
			break;
		}
	}
}

if (!isset($autoloader) && !defined('VENDOR_DIR')) {
	// Used as stand alone
	if (\file_exists(__DIR__ . '/../vendor/autoload.php')) {
		define('VENDOR_DIR', dirname(__DIR__ . '/../vendor/autoload.php'));
	}
	
	// Installed as dependency
	elseif (\file_exists(__DIR__ . '/../../autoload.php')) {
		define('VENDOR_DIR', dirname(__DIR__ . '/../../../autoload.php'));
	}
	
	else {
		throw new \InvalidArgumentException('Can not find vendor directory, update dependencies with composer first!');
	}
	
	$autoloader = require_once(VENDOR_DIR .  '/autoload.php');
}

$autoloader->addPsr4('nexxes\\widgets\\html\\', __DIR__);
