<?php

namespace nexxes\widgets\html;

use \nexxes\widgets\PageInterface;
use \nexxes\widgets\PageTrait;
use \nexxes\widgets\WidgetContainerTrait;

abstract class Page implements PageInterface {
	use PageTrait, WidgetContainerTrait;
	
	
	
	
	public function __construct() {
		$this->getEventDispatcher()->addSubscriber(new FormSynchronizer());
	}
	
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
		
		foreach ($this->children() AS $child) {
			$r .= $child;
		}
		
		$r .= '</body>';
		$r .= '</html>';
		
		return $r;
	}
}
