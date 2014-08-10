<?php

namespace nexxes\widgets\interfaces;

/**
 * Represents a style sheet definition to embedd in the HEAD of an html document.
 */
interface StyleSheet {
	/**
	 * Create an html string to put into the HEAD of a document
	 */
	function __toString();
}
