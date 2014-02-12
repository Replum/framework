<?php

namespace nexxes;

/**
 * A data source that works on doctrine entities.
 * 
 * Uses an entity type as the base and allows filtering and sorting based on its properties.
 * Even properties of relations are allowed and result in automatic join building.
 */
class DoctrineDataSource implements \IteratorAggregate, DataSourceInterface {
	/**
	 * The entity manager that is responsible for fetching entities from database 
	 * 
	 * @var \Doctrine\ORM\EntityManager
	 */
	private $em;
	
	/**
	 * Type/class of the entites to use as base
	 * 
	 * @var \Doctrine\ORM\Mapping\ClassMetadata
	 */
	private $entity;
	
	/**
	 * This query builder is used to determine what entries to fetch
	 * 
	 * @var \Doctrine\ORM\QueryBuilder
	 */
	private $queryBuilder;
	
	/**
	 * A list of fields you may fetch with this data source
	 * 
	 * @var array<string>
	 */
	protected $fields;
	
	/**
	 * May contain a list of field=>fieldDisplayName pairs or an object implementing the StringTranslatorInterface
	 * 
	 * @var array<string>|\nexxes\StringTranslatorInterface
	 */
	protected $names;
	
	/**
	 * The current result or null if no fetch happened
	 * 
	 * @var \Doctrine\Common\Collections\ArrayCollection
	 */
	private $result;
	
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
	 * Boolean filter to use in where clause
	 * 
	 * @var \Doctrine\ORM\Query\Expr\Andx
	 */
	private $filter;
	
	
	
	
	/**
	 * 
	 * @param \Doctrine\ORM\EntityManager $em
	 * @param string $entity
	 * @param array<string> $fields
	 * @param array<string>|StringTranslatorInterface $names
	 */
	public function __construct(\Doctrine\ORM\EntityManager $em, $entity, $fields, $names) {
		$this->em = $em;
		$this->entity = $this->em->getClassMetadata($entity);
		$this->fields = $fields;
		$this->names = $names;
		$this->queryBuilder = $this->em->createQueryBuilder();
		$this->queryBuilder->from($this->entity->getName(), 'root');
	}
	
	/**
	 * Get a display name for the supplied field
	 * 
	 * @param string $field
	 * @return string
	 */
	public function fieldName($field) {
		if ($this->names instanceof StringTranslatorInterface) {
			return $this->names->translate($field);
		}
		
		elseif (\is_array($this->names) && isset($this->names[$field])) {
			return $this->names[$field];
		}
		
		else {
			return $field;
		}
	}
	
	/**
	 * List of available field names
	 * 
	 * @return array<string>
	 */
	public function fields() {
		return $this->fields;
	}
	
	public function filter($field, $value, $compareBy = '=') {
		if (is_null($this->filter)) {
			$this->filter = $this->queryBuilder->expr()->andX();
			$this->queryBuilder->where($this->filter);
		}
		
		$name = $this->_getJoinName($this->entity, $field);
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
		
		$this->filter->add($this->queryBuilder->expr()->{$methods[$compareBy]}($name, $this->queryBuilder->expr()->literal($value)));
	}
	
	public function limit($start = 0, $count = null) {
		$this->limitStart = $start;
		$this->limitCount = $count;
	}
	
	public function sort($field, $direction = 'asc') {
		$name = $this->_getJoinName($this->entity, $field);
		$this->queryBuilder->addOrderBy($name, $direction);
	}
	
	/**
	 * @implements \Countable
	 * @return int
	 */
	public function count() {
		$result = $this->queryBuilder->select('COUNT(root.id) as entry_count')->setFirstResult(null)->setMaxResults(null)->getQuery()->getOneOrNullResult();
		return (int)$result['entry_count'];
	}
	
	/**
	 * Get the current result.
	 * Fetch it if no result existed
	 * 
	 * @return \Doctrine\Common\Collections\ArrayCollection
	 */
	private function fetchResult() {
		if (is_null($this->result)) {
			$this->result = $this->queryBuilder->getQuery()->execute();
		}
		
		return $this->result;
	}

	public function getIterator() {
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
}

