<?php

namespace nexxes;

/**
 * A data source is the container for a list of data objects.
 * 
 * A DataSource must also implement \Traversable so iterating with foreach is possible
 * and \Countable so count($dataSource) will the return the total number of available entries
 */
interface iDataSource extends \Traversable, \Countable {
	/**
	 * @return array<string> List of field names a row contains
	 */
	public function fields();
	
	/**
	 * Get the display name for a field
	 * 
	 * @param string $field
	 * @return string
	 */
	public function fieldName($field);
	
	/**
	 * Modify the sort order of this datasource
	 * 
	 * @param string $field The field identifier to sort by
	 * @param string $direction asc|desc for ascending or descending order
	 * @return iDataSource $this
	 */
	//public function sort($field, $direction = 'asc');
	
	/**
	 * Limit the rows to use when iterating over the data
	 * 
	 * @param int $start The first row to use (starting from 0)
	 * @param int $count Number of rows to show, -1 for all rows up to the last
	 * @return iDataSource $this
	 */
	//public function limit($start = 0, $count = 15);
	
	/**
	 * Filter the contained data
	 * 
	 * @param string $field The field name to filter by
	 * @param mixed $value Compare the field values to this value
	 * @param mixed $compareBy Use to compare the field to the value
	 * @return iDataSource $this
	 */
	//public function filter($field, $value, $compareBy = '=');
}
