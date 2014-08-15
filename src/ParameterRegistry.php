<?php

namespace nexxes\widgets;

/**
 * The parameter registry enabled widgets to link their widget properies to parameters supplied buy GET/POST variables.
 * 
 * Example:
 * Assume the following simple widget class:
 * 
 * <code>
 * class Foo extends Widget {
 *	private $bar;
 *	public function setBar($newbar);
 * }
 * </code>
 * 
 * The $bar property of the Foo widget should get the value of a request variable $baz automatically assigned on each successive call to the page, e.g. via event AJAX requests.
 * On page creation, the widget has to register itself for that request variable by calling the register() method of the ParameterRegistry instance of the current page.
 * 
 * Only one widget can be registered for every parameter.
 * If two table widgets exists on a page that both try to claim a $sort request variable, sorting one table would unsort the other.
 * In this case, request variables should be prefixed by the widget ID or some other "namespace", e.g. table1.sort and table2.sort.
 */
class ParameterRegistry {
	/**
	 * [widget => $widget, setter => $setter, validator => $validator] for each $requestVar
	 * 
	 * @var array
	 */
	private $params = [];
	
	
	
	
	/**
	 * Registers a widget for a request variable.
	 * 
	 * Setter and validator should be methods of the widget. 
	 * If a validator is supplied, the return value of the validator is used as the input for the setter.
	 * 
	 * Both callbacks should have the following signature:
	 * <code>function callback($value)</code>
	 * 
	 * Closures must not be used as callback as they can not be serialized.
	 * 
	 * @param string $requestVar The request variable to bind the widget to.
	 * @param \nexxes\widgets\WidgetInterface $widget The widget that claims the variable.
	 * @param callable $setter Callback to set the variable.
	 * @param callable $validator Callback to validate the variable.
	 * @return ParameterRegistry $this for chaining.
	 */
	public function register($requestVar, WidgetInterface $widget, callable $setter, callable $validator = null) {
		if (isset($this->params[$requestVar])) {
			throw new \InvalidArgumentException('Parameter "' . $requestVar . '" is already bound to another widget!');
		}
		
		$this->params[$requestVar] = [
			'widget' => $widget,
			'setter' => $setter,
			'validator' => $validator,
		];
		
		return $this;
	}
	
	/**
	 * Read request variables and feed them into the registered widgets
	 * 
	 * @param array $data
	 * @return \nexxes\widgets\ParameterRegistry $this for chaining
	 */
	public function import($data) {
		foreach ($data as $requestVar => $value) {
			if (!isset($this->params[$requestVar])) { continue; }
			
			if ($this->params[$requestVar]['validator'] != null) {
				$value = \call_user_func($this->params[$requestVar]['validator'], $value);
			}
			
			\call_user_func($this->params[$requestVar]['setter'], $value);
		}
		
		return $this;
	}
	
	/**
	 * Unregister all request variables assigned by the supplied widget.
	 * Use if a widget is replaced by another widget.
	 * 
	 * @param \nexxes\widgets\WidgetInterface $widget
	 * @return \nexxes\widgets\ParameterRegistry $this for chaining
	 */
	public function unregister(\nexxes\widgets\WidgetInterface $widget) {
		foreach ($this->params AS $requestVar => $settings) {
			if ($settings['widget'] !== $widget) { continue; }
			
			unset($this->params[$requestVar]);
		}
		
		return $this;
	}
}
