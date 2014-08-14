<?php

namespace nexxes\widgets\html;

use \nexxes\widgets\interfaces;
use \nexxes\widgets\traits;

abstract class Page implements interfaces\Page {
	use traits\Page, traits\WidgetContainer, traits\Widget;
	
	public $id = "";
	
	
	public function __construct() {
		
	}
	
	/**
	 * @implements \nexxes\widgets\interfaces\Page
	 */
	public function escape($string) {
		return \htmlentities($string, null, 'UTF-8');
	}
	
	/**
	 * @implements \nexxes\widgets\interfaces\Widget
	 */
	public function __toString() {
		$r  = '<!DOCTYPE html>';
		$r .= '<html>';
		
		$r .= '<head>';
		$r .= '<title>' . $this->escape($this->getTitle()) . '</title>';
		$r .= '<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />';
		$r .= '<meta name="viewport" content="width=device-width, initial-scale=1.0" />';
		
		foreach ($this->getScripts() AS $script) {
			$r .= $script;
		}
		
		foreach ($this->getStyleSheets() AS $style) {
			$r .= $style;
		}
		
		$r .= '</head>';
		
		$r .= '<body id="' . $this->escape($this->id) . '">';
		
		foreach ($this AS $child) {
			$r .= $child;
		}
		
		$r .= '</body>';
		$r .= '</html>';
		
		return $r;
	}
}
