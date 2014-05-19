<?php

namespace nexxes;

use \nexxes\dependency\Gateway as dep;

/**
 * A data source that works on doctrine entities.
 * 
 * Uses an entity type as the base and allows filtering and sorting based on its properties.
 * Even properties of relations are allowed and result in automatic join building.
 */
class DoctrineDataSource implements \IteratorAggregate, iDataSource {
	/**
	 * Name of the model manager class to look up in the dependency registry
	 * 
	 * @var string
	 */
	private $modelManagerName;
	
	/**
	 * Class name of a name translator to use for human readable field names
	 * 
	 * @var string
	 */
	private $nameTranslator;
	
	/**
	 * Type/class name of the entites to use as base
	 * 
	 * @var string
	 */
	private $entity;
	
	/**
	 * A list of fields you may fetch with this data source
	 * Contains fieldname => [displayname, fetchdef] associations
	 * 
	 * @var array
	 */
	private $fields = [];
	
	/**
	 * The first result of the list of result to retrieve, starts from 0
	 * 
	 * @var int
	 */
	private $limitStart = null;
	
	/**
	 * The number of results to fetch, null means all results
	 * 
	 * @var int
	 */
	private $limitCount = null;
	
	/**
	 * List of filter criteria to apply. Contains [fieldname, compareOperator, compareTo] tupples
	 * 
	 * @var array
	 */
	private $filter = [];
	
	/**
	 * List of sort criteria, contains [fieldname, direction] pairs
	 * 
	 * @var array
	 */
	private $sorter = [];
	
	
	
	
	/**
	 * The entity manager that is responsible for fetching entities from database 
	 * 
	 * @var \Doctrine\ORM\EntityManager
	 */
	private $em;
	
	/**
	 * This query builder is used to determine what entries to fetch
	 * 
	 * @var \Doctrine\ORM\QueryBuilder
	 */
	private $queryBuilder;
	
	/**
	 * Meta information about the fields
	 * 
	 * @var array
	 */
	private $meta = [];
	
	/**
	 * The current result or null if no fetch happened
	 * 
	 * @var \Doctrine\Common\Collections\ArrayCollection
	 */
	private $result;
	
	
	
	
	/**
	 * 
	 * @param string $entity
	 * @param string $modelManagerName Name of the model manager class to look up in the registry
	 */
	public function __construct($entity, $modelManagerName = \birkholz\common\DoctrineModelManager::class) {
		$this->entity = $entity;
		$this->modelManagerName = $modelManagerName;
	}
	
	
	
	
	/**
	 * Register a string translator that is used to create human readable field names for e.g. column headings.
	 * Translator is fetched via the dependency registry.
	 * 
	 * @param string $translatorDependencyName Dependency name of the translator, must be accessible by the dependency registry
	 * @return $this for chaining
	 */
	public function setNameTranslator($translatorDependencyName) {
		$this->nameTranslator = $translatorDependencyName;
		return $this;
	}
	
	
	
	
	/**
	 * Specify a field that can be accessed by this datasource.
	 * 
	 * $display and $fetchby default to $field.
	 * 
	 * @param string $field The unique identifier of this field and used e.g. in sort/filter url parameters.
	 * @param string $display The human readable name used for column headers
	 * @param string $fetchby The qualified possibly nested field qualifier which may also contain aggregate functions like COUNT, MIN, MAX, etc.
	 * @return $this for chaining
	 */
	public function addField($field, $display = null, $fetchby = null) {
		if (is_null($display)) {
			$display = $field;
		}
		
		if (is_null($fetchby)) {
			$fetchby = $field;
		}
		
		$this->fields[$field] = [$display, $fetchby];
		
		return $this;
	}
	
	
	
	
	/**
	 * Get a display name for the supplied field
	 * 
	 * @param string $field
	 * @return string
	 */
	public function fieldName($field) {
		if (isset($this->nameTranslator) && ($this->nameTranslator != '')) {
			$tr = dep::get($this->nameTranslator);
			if ($tr instanceof StringTranslatorInterface) {
				return $tr->translate($this->fields[$field][0]);
			}
			
			else {
				throw new \RuntimeException('Name translator dependency "' . $this->nameTranslator . '" must implement interface ' . StringTranslatorInterface::class);
			}
		}
		
		else {
			return $this->fields[$field][0];
		}
	}
	
	public function fieldRow($field) {
		return $this->fields[$field][1];
	}
	
	
	
	/**
	 * List of available field identifiers
	 * 
	 * @return array<string>
	 */
	public function fields() {
		return \array_keys($this->fields);
	}
	
	
	
	public function addFilter($field, $value, $compareBy = '=') {
		$this->filter[] = [$field, $compareBy, $value];
		
		return $this;
	}
	
	public function setSort($field, $direction) {
		$this->sorter = [];
		$this->sorter[] = [$field, $direction];
		
		if ($field != 'id') {
			$this->sorter[] = ['id', 'desc'];
		}
		
		return $this;
	}
	
	public function limit($start = 0, $count = null) {
		$this->limitStart = $start;
		$this->limitCount = $count;
		
		return $this;
	}
	
	
	/**
	 * 
	 */
	protected function prepareQueryBuilder() {
		$this->em = dep::get($this->modelManagerName)->doctrine;
		
		$this->meta = [];
		$this->meta['root'] = [
				'entity' => $this->em->getClassMetadata($this->entity),
				'name' => 'root',
		];
		
		$this->queryBuilder = $this->em->createQueryBuilder();
		$this->queryBuilder->from($this->meta['root']['entity']->getName(), 'root');
		
		if (\count($this->filter)) {
			$whereParts = $this->queryBuilder->expr()->andX();
			$this->queryBuilder->where($whereParts);

			foreach ($this->filter AS list($field, $compareBy, $value)) {
				$name = $this->_getJoinName($this->meta['root']['entity'], (isset($this->fields[$field]) ? $this->fields[$field][1] : $field));
				$methods = [
						'<' => 'lt',
						'<=' => 'lte',
						'=' => 'eq',
						'>=' => 'gte',
						'>' => 'gt',
						'<>' => 'neq',
						'!=' => 'neq',
						'like' => 'like',
						'notLike' => 'notLike',
				];
				
				if ($compareBy == 'in') {
					if (\is_array($value)) {
						$newvalue = $value;
					} else {
						$newvalue = [];
						foreach ($value AS $obj) {
							$newvalue[] = $obj->id;
						}
					}
					
					$whereParts->add($this->queryBuilder->expr()->in($name, $newvalue));
				}
				
				else {
					$whereParts->add($this->queryBuilder->expr()->{$methods[$compareBy]}($name, $this->queryBuilder->expr()->literal($value)));
				}
			}
		}
		
		foreach ($this->sorter AS list ($field, $direction)) {
			$name = $this->_getJoinName($this->meta['root']['entity'], (isset($this->fields[$field]) ? $this->fields[$field][1] : $field));
			$this->queryBuilder->addOrderBy($name, $direction);
		}
		
		return $this;
	}
	
	
	
	
	/**
	 * @implements \Countable
	 * @return int
	 */
	public function count() {
		if (is_null($this->queryBuilder)) {
			$this->prepareQueryBuilder();
		}
		
		$result = $this->queryBuilder->select('COUNT(root.id) as entry_count')->setFirstResult(null)->setMaxResults(null)->getQuery()->getOneOrNullResult();
		return (int)$result['entry_count'];
	}
	
	public function getIterator() {
		if (is_null($this->queryBuilder)) {
			$this->prepareQueryBuilder();
		}
		
		$result = $this->queryBuilder->select('root')->setFirstResult($this->limitStart)->setMaxResults($this->limitCount)->getQuery()->execute();
		return new \ArrayIterator($result);
	}
	
	
	/**
	 * The list of alias names for qualifiers as used in joins
	 * 
	 * @var array<string>
	 */
	private $aliases = [];
	
	/**
	 * Class metadata cache
	 * @var array<\Doctrine\ORM\Mapping\ClassMetadata>
	 */
	private $entites = [];
	
	/**
	 * Get the join name for a field and create all required joins to access this field.
	 * For a field bla.blubb.baz of type foo there will be:
	 * - a join on foo.bla with name joinX
	 * - a join on joinX.blubb with name joinY
	 * the return will be joinY.blubb
	 * 
	 * If any of the joins are used already, they are reused.
	 * 
	 * @param \Doctrine\ORM\Mapping\ClassMetadata $entity
	 * @param string $resolve Full qualified field name to resolve
	 * @param string $prefix Only used in recursion
	 * @return string
	 * @throws \RuntimeException
	 */
	private function _getJoinName(\Doctrine\ORM\Mapping\ClassMetadata $entity, $resolve, $prefix = '') {
		@list($field, $resolve) = \explode('.', $resolve, 2);
		$qualifier = ($prefix != '' ? $prefix . '.' : '') . $field;
		
		if (!$resolve) {
			return ($prefix != '' ? $this->aliases[$prefix] : 'root') . '.' . $field;
		}
		
		// Load entity data only if not already loaded
		if (!isset($this->entities[$qualifier])) {
			if (!$entity->hasAssociation($field)) {
				throw new \RuntimeException('Unknown field "' . $field . '" for entity "' . $entity->name . '"');
			}
		
			$this->entities[$qualifier] = $this->em->getClassMetadata($entity->getAssociationTargetClass($field));
			$this->aliases[$qualifier] = 'join' . \count($this->aliases);
			$this->queryBuilder->leftJoin(($prefix != '' ? $this->aliases[$prefix] : 'root') . '.' . $field, $this->aliases[$qualifier]);
		}
		
		return $this->_getJoinName($this->entities[$qualifier], $resolve, $qualifier);
	}
	
	
	public function __sleep() {
		return [
			'modelManagerName',
			'nameTranslator',
			'entity',
			'fields',
			'limitStart',
			'limitCount',
			'filter',
			'sorter',
		];
	}
}

