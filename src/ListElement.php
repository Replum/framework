<?php

/*
 * This file is part of the nexxes/widgets-html package.
 * 
 * Copyright (c) Dennis Birkholz, nexxes Informationstechnik GmbH <dennis.birkholz@nexxes.net>
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

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
