<?php

namespace nexxes\widgets\pagedef;

use \nexxes\widgets\WidgetInterface;

/**
 * The importer reads a page structure stored in an importer specific format and
 *  returns PHP code that can be evaluated as a closure.
 * 
 * This closure accepts one parameter of type WidgetInterface and performs all
 *  widget creation and initialization on the supplied root widget.
 * 
 * The importer returns the closure as PHP code so it can be written to a file
 *  which can directly return the closure when included.
 * 
 * @author Dennis Birkholz <dennis.birkholz@nexxes.net>
 */
interface ImporterInterface {
	/**
	 * Read the supplied file and create the initialization closure.
	 * 
	 * @param WidgetInterface $root The widget to initialize
	 * @param string $filename File containing the structure definition in a format the importer can handle
	 * @return string PHP code for the initialization closure
	 */
	function importFile(WidgetInterface $root, $filename);
	
	/**
	 * Use the supplied data to create the initialization closure.
	 * 
	 * @param WidgetInterface $root The widget to initialize
	 * @param mixed $data Data containing the structure definition in a format the importer can handle
	 * @return string PHP code for the initialization closure
	 */
	function import(WidgetInterface $root, $data);
}
