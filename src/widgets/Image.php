<?php

namespace nexxes\widgets;

use \nexxes\property\Config;

class Image extends \nexxes\Widget {
	/**
	 * The source URL of the image
	 * 
	 * @var string
	 * @Config(type="string")
	 */
	public $src;
	
	
	
	
	public function __construct($src, $title) {
		parent::__construct();
		
		$this->src = $src;
		$this->title = $title;
	}
	
	public function renderHTML() {
		return '<img src="' . $this->src . '" alt="' . $this->escape($this->title) . '" ' . $this->renderCommonAttributes() . ' />';
	}
}
