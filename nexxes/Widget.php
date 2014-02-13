<?php

namespace nexxes;

use \nexxes\property\Config;

/**
 * Base class that can be used for all widgets
 */
abstract class Widget implements iWidget, \Serializable {
	use property\ChangeMonitoringTrait;
	use property\UpdateValuesTrait;
	
	public function __construct() {
		$this->id = PageContext::$widgetRegistry->register($this);
		$this->_initializeChangeMonitoring();
	}
	
	/**
	 * @Config(type="string")
	 */
	public $id;
	
	
	/**
	 * Return a clean smarty instance
	 * 
	 * @return \Smarty
	 */
	protected function smarty() {
		$smarty = clone PageContext::$smarty;
		$smarty->assign('id', $this->id);
		$smarty->assign('widget', $this);
		
		return $smarty;
	}
	
	public function serialize() {
		return $this->_SerializeChangeMonitor();
	}
	
	public function unserialize($serialized) {
		$this->_UnserializeChangeMonitor($serialized);
		$this->updateValues();
	}
}
