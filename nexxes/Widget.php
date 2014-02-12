<?php

namespace nexxes;

use \nexxes\property\Config;

/**
 * Base class that can be used for all widgets
 */
class Widget implements WidgetInterface, \Serializable {
	use property\ChangeMonitoringTrait;
	use property\UpdateValuesTrait;
	
	public function __construct(PageContext $context) {
		$this->setContext($context);
		$this->_initializeChangeMonitoring();
	}
	
	/**
	 * @Config(type="string")
	 */
	public $id;
}
