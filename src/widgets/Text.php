<?php

namespace nexxes\widgets;

use \nexxes\property\Config;

class Text extends \nexxes\Widget {
	/**
	 * @var string
	 * @Config(type="string")
	 */
	public $text;
	
	/**
	 * @var string
	 * @Config(type="string", match="/^(p|h1|h2|h3|h4|h5|h6|div|span)$/")
	 */
	public $type;
	
	public function __construct($text = '', $type = null) {
		parent::__construct();
		
		$this->text = $text;
		if ($type) {
			$this->type = $type;
		}
	}
	
	public function renderHTML() {
		$s = $this->smarty();
		
		$commonAttributes = $this->renderCommonAttributes();
		if ($commonAttributes != "") {
			if (!$this->type) {
				$this->type = 'span';
			}
			$s->assign('commonAttributes', $commonAttributes);
		}
		
		return $s->fetch(__DIR__ . '/Text.tpl');
	}
}
