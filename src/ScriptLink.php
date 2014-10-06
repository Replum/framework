<?php

namespace nexxes\widgets\html;

use \nexxes\widgets\ScriptInterface;

/**
 * Description of ScriptLink
 *
 * @author dennis
 */
class ScriptLink implements ScriptInterface {
/**
	 * The url of the style sheet
	 * @var string
	 */
	private $url = null;
	
	/**
	 * @param string $url
	 * @return \nexxes\widgets\html\StyleSheetLink $this for chaining
	 */
	public function setUrl($url) {
		$this->url = $url;
		return $this;
	}
	
	
	
	public function __toString() {
		return '<script src="' . \htmlentities($this->url, null, 'UTF-8') . '?t=' . time() . '"></script>';
	}
}
