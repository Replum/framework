<?php

namespace nexxes\widgets\form;

use \nexxes\property\Config;

class Suggestor extends \nexxes\Widget {
	/**
	 * @var string
	 * @Config(type="string")
	 */
	public $name;
	
	/**
	 * @var string
	 * @Config(type="string")
	 */
	public $url;
	
	/**
	 * The template to use for the suggestions.
	 * The template is parsed using Handlebars.
	 * 
	 * @see http://handlebarsjs.com/
	 * @var string
	 * @Config(type="string")
	 */
	public $template;
	
	/**
	 * Selector for jQuery to enable suggestions.
	 * Will be '.className' in most cases
	 * @var string
	 * @Config(type="string")
	 */
	public $selector;
	
	/**
	 * Number of suggestions to show
	 * @var int
	 * @Config(type="int")
	 */
	public $suggestions = 15;
	
	public function __construct($name, $selector, $url, $template, $suggestions = 15) {
		parent::__construct();
		
		$this->name = $name;
		$this->selector = $selector;
		$this->url = $url;
		$this->template = $template;
		$this->suggestions = $suggestions;
	}
	
	public function renderHTML() {
		return '<script>nexxes.simpleWidget.registerSuggest("' . $this->name . '", "'. $this->selector . '", "' . $this->url . '", "' . \addslashes($this->template) . '", ' . $this->suggestions . ');</script>' . PHP_EOL;
	}
}
