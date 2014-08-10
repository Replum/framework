<?php

namespace nexxes\widgets\interfaces;

/**
 * Represents a script definition to embedd in the HEAD of an html document.
 */
interface Script {
	/**
	 * Create an html string to put into the HEAD of a document
	 */
	function __toString();
}
