<?php

namespace nexxes\widgets\bootstrap;

use \nexxes\widgets\html\StyleSheetLink;
use \nexxes\widgets\html\ScriptLink;

/**
 * @author Dennis Birkholz <dennis.birkholz@nexxes.net>
 */
abstract class Page extends \nexxes\widgets\html\Page {
	public function __construct() {
		$this->addStyleSheet((new StyleSheetLink())->setUrl('/components/bootstrap/css/bootstrap.css'));
		$this->addStyleSheet((new StyleSheetLink())->setUrl('/components/bootstrap/css/bootstrap-theme.css'));
		
		$this->addScript((new ScriptLink())->setUrl('/components/jquery/jquery.js'));
		$this->addScript((new ScriptLink())->setUrl('/components/bootstrap/js/bootstrap.js'));
	}
}
