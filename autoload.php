<?php

/**
 * Make autoloading of composer managed dependencies available
 * Autoloader is registered as dependency '\Composer\Autoload\ClassLoader'
 */

if (!defined('VENDOR_DIR')) {
	// Used as stand alone
	if (\file_exists(__DIR__ . '/vendor/autoload.php')) {
		define('VENDOR_DIR', dirname(__DIR__ . '/vendor/autoload.php'));
	}
	
	// Installed as dependency
	elseif (\file_exists(__DIR__ . '/../../autoload.php')) {
		define('VENDOR_DIR', dirname(__DIR__ . '/../../autoload.php'));
	}
	
	else {
		throw new \InvalidArgumentException('Can not find vendor directory, update dependencies with composer first!');
	}
	
	$autoloader = require_once(VENDOR_DIR .  '/autoload.php');
	
	$autoloader->addPsr4('nexxes\\widgets\\', __DIR__ . '/test');
	
	// Load dependencies injected by composer
	\nexxes\dependency\Gateway::registerObject(\Composer\Autoload\ClassLoader::class, $autoloader);
}
