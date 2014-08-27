<?php

namespace nexxes\widgets\bootstrap;

use \nexxes\widgets\html\StyleSheetLink;
use \nexxes\widgets\html\ScriptLink;

/**
 * @author Dennis Birkholz <dennis.birkholz@nexxes.net>
 */
abstract class Page extends \nexxes\widgets\html\Page {
	public function __construct() {
		$this->addStyleSheet((new StyleSheetLink())->setUrl('/vendor/nexxes/widgets-base/css/bootstrap-3.2.0.css'));
		$this->addStyleSheet((new StyleSheetLink())->setUrl('/vendor/nexxes/widgets-base/css/bootstrap-theme-3.2.0.css'));
		
		$this->addScript((new ScriptLink())->setUrl('/vendor/nexxes/widgets-base/js/jquery-1.11.1.js'));
		$this->addScript((new ScriptLink())->setUrl('/vendor/nexxes/widgets-base/js/bootstrap-3.2.0.js'));
	}
}
