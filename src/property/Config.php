<?php

namespace nexxes\property;

/**
 * Stores all configuration settings extracted from annotations
 * 
 * @Annotation
 * @Target("PROPERTY")
 */
class Config {
	/**
	 * The type this parameter can have
	 * Can be bool|int|float|string or a (full qualified) class
	 * 
	 * @var string
	 */
	public $type = "string";
	
	/**
	 * Read the value for this parameter from the request or not
	 * 
	 * @var bool
	 */
	public $fill = false;
	
	/**
	 * This parameter is an array: it can contain multiple values of the same type
	 * 
	 * @var bool
	 */
	public $array = false;
	
	/**
	 * A regular expression to validate the contents
	 * 
	 * @var string
	 */
	public $match;
	
	/**
	 * Method name of the class to use to validate the contents
	 * 
	 * @var string
	 */
	public $validate;
	
	/**
	 * The minimum value for int or float parameters
	 * 
	 * @var float
	 */
	public $min;
	
	/**
	 * The maximum value for int for float parameters
	 * @var float
	 */
	public $max;
	
	
	
	
	/**
	 * The name of the property
	 * Do not use directly in annotation
	 * 
	 * @var string
	 */
	public $name;
	
	/**
	 * Type is a scalar variable, not a class type
	 * Do not use in annotation, calculated from type
	 * 
	 * @var bool
	 */
	public $scalar = true;
}
