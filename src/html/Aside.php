<?php

namespace nexxes\widgets\html;

use \nexxes\widgets\WidgetContainer;

/**
 * The aside element represents a section of a page that consists of content that is tangentially related to the content around the aside element, and which could be considered separate from that content. Such sections are often represented as sidebars in printed typography.
 * 
 * The element can be used for typographical effects like pull quotes or sidebars, for advertising, for groups of nav elements, and for other content that is considered separate from the main content of the page.
 * 
 * @author Dennis Birkholz <dennis.birkholz@nexxes.net>
 * @link http://www.w3.org/TR/html5/sections.html#the-aside-element
 */
class Aside extends WidgetContainer {
	/**
	 * {@inheritdoc}
	 */
	protected function validTypes() {
		return [ 'aside' ];
	}
}
