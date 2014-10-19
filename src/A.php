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
use \nexxes\widgets\WidgetHasClickEventInterface;
use \nexxes\widgets\WidgetHasClickEventTrait;

/**
 * @author Dennis Birkholz <dennis.birkholz@nexxes.net>
 * @property string $href The url to use for this link
 */
class A extends WidgetContainer implements WidgetHasClickEventInterface {
	use WidgetHasClickEventTrait;
	
	
	protected function validTags() {
		return ['a'];
	}
	
	/**
	 * @var string
	 */
	private $href;
	
	/**
	 * @return string
	 */
	public function getHref() {
		return $this->href;
	}
	
	/**
	 * @param string $newHref
	 * @return \nexxes\widgets\html\A $this for chaining
	 */
	public function setHref($newHref) {
		if ($newHref !== $this->href) {
			$this->href = $newHref;
			$this->setChanged(true);
		}
		
		return $this;
	}
	
	protected function renderAttributes() {
		return parent::renderAttributes()
			. (!\is_null($this->href) ? ' href="' . $this->escape($this->href) . '"' : '')
		;
	}
}
