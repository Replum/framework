<?php

namespace nexxes\widgets\html;

use \nexxes\widgets\WidgetContainer;

/**
 * @author Dennis Birkholz <dennis.birkholz@nexxes.net>
 */
class ListElement extends WidgetContainer {
	/**
	 * {@inheritdoc}
	 */
	protected function validTypes() {
		return [ 'li' ];
	}
}
