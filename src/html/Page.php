<?php

namespace nexxes\widgets\html;

use \nexxes\widgets;

abstract class Page implements widgets\PageInterface {
	use widgets\PageTrait, widgets\WidgetContainerTrait, widgets\WidgetTrait;
	
	public $id = "";
	
	
	/**
	 * {@inheritdoc}
	 */
	public function escape($unquoted) {
		return \htmlentities($unquoted, null, 'UTF-8');
	}
	
	/**
	 * {@inheritdoc}
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
