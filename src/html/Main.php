<?php

namespace nexxes\widgets\html;

use \nexxes\widgets\WidgetContainer;

/**
 * The main element represents the main content of the body of a document or application. The main content area consists of content that is directly related to or expands upon the central topic of a document or central functionality of an application.
 * 
 * @author Dennis Birkholz <dennis.birkholz@nexxes.net>
 * @link http://www.w3.org/TR/html5/grouping-content.html#the-main-element
 */
class Main extends WidgetContainer {
	/**
	 * {@inheritdoc}
	 */
	protected function validTypes() {
		return [ 'main' ];
	}
}
