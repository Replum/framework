<?php

namespace nexxes;

interface StringTranslatorInterface {
	/**
	 * Translate the supplied string to the preconfigured target language.
	 * 
	 * @param string $str
	 * @return string
	 */
	public function translate($str);
}
