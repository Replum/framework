<?php

namespace nexxes\widgets;

/**
 * @author Dennis Birkholz <dennis.birkholz@nexxes.net>
 */
class PageTraitMock implements PageInterface {
	use PageTrait, WidgetContainerTrait {
		PageTrait::__wakeup as private PageTraitWakeup;
		WidgetContainerTrait::__wakeup as private WidgetContainerTraitWakeup;
	}
	
	public $testref;
	
	public $testprop1;
	
	public function setTestprop1($newTestprop1) {
		$this->testprop1 = $newTestprop1;
	}
	
	public $publicTestProp;
	
	protected $protectedTestProp;
	
	private $privateTestProp;
	
	public function __toString() {
		return "";
	}
	
	public function __wakeup() {
	}
}
