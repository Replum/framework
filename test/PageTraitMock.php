<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace nexxes\widgets;

/**
 * Description of PageTraitMock
 *
 * @author Dennis Birkholz <dennis.birkholz@nexxes.net>
 */
class PageTraitMock implements PageInterface {
	use PageTrait, WidgetContainerTrait, WidgetTrait;

	public function __toString() {
	}
}
