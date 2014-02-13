<?php

namespace nexxes;

use \nexxes\property\Config;

/**
 * Base class that can be used for all widgets
 */
class Widget implements iWidget, \Serializable {
	use property\ChangeMonitoringTrait;
	use property\UpdateValuesTrait;
	
	public function __construct() {
		$this->_initializeChangeMonitoring();
	}
	
	/**
	 * @Config(type="string")
	 */
	public $id;
}
