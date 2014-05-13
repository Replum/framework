<?php

namespace nexxes;

class WidgetFactory {
	private $namespaces = [];
	
	
	/**
	 * Create a widget factory and register the supplied namespaces as search namespaces
	 * 
	 * @param string $namespace1
	 * @param ...string $namespace2
	 */
	public function __construct($namespace1, $namespace2 = '') {
		$args = \func_get_args();
		
		foreach ($args AS $arg) {
			$this->namespaces[] = $arg;
		}
	}
	
	/**
	 * Create a new widget of the supplied type.
	 * The widget name can be a fully qualified classname (starting with a \)
	 * or relative to one of the registered name spaces.
	 * The supplied arguments will be applied to the widget afterwards.
	 * The argument array should container key=>value pairs where each key represents a property of the created widget.
	 * 
	 * @param string $widgetname
	 */
	public function create($widgetname, $propertyName1 = null, $propertyValue1 = null) {
		if ($widgetname[0] == '\\') {
			if (!\class_exists($widgetname)) {
				throw new \InvalidArgumentException('Unknown widget class "' . $widgetname . '", can not create.');
			}
			$widget = new $widgetname();
		}
		
		else {
			foreach ($this->namespaces AS $ns) {
				$class = $ns . '\\' . $widgetname;
				if (\class_exists($class)) {
					$widget = new $class();
					break;
				}
			}
		}
		
		if (is_null($widget)) {
			throw new \InvalidArgumentException('Unknown widget class "' . $widgetname . '", not found in any namespace.');
		}
		
		if (!($widget instanceof iWidget)) {
			throw new \InvalidArgumentException('Widget class "' . \get_class($widget) . '" does not implement \nexxes\iWidget interface!');
		}
		
		$args = \func_get_args();
		array_shift($args);
		
		while (\count($args)) {
			$key = \array_shift($args);
			$value = \array_shift($args);
			
			$widget->set($key, $value);
		}
		
		$widget->initialize();
		
		return $widget;
	}
	
	public function __invoke() {
		$args = \func_get_args();
		return call_user_func_array([$this, 'create'], $args);
	}
}
