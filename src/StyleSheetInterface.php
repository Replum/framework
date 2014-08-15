<?php

namespace nexxes\widgets;

/**
 * Represents a style sheet definition to embedd in the HEAD of an html document.
 */
interface StyleSheetInterface {
	/**
	 * Create an html string to put into the HEAD of a document
	 */
	function __toString();
}
