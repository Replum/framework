<?php

namespace nexxes\widgets;

/**
 * @author Dennis Birkholz <dennis.birkholz@nexxes.net>
 */
trait WidgetContainerTrait {
	use WidgetTrait;
	
	/**
	 * @var WidgetCollection
	 */
	private $WidgetContainerTraitChildren;
	
	/**
	 * @implements WidgetContainerInterface
	 */
	public function children() {
		if (is_null($this->WidgetContainerTraitChildren)) {
			$this->WidgetContainerTraitChildren = new WidgetCollection($this, false);
		}
		
		return $this->WidgetContainerTraitChildren;
	}
	
	/**
	 * Simple helper to iterate over all children and render them.
	 * @return string
	 */
	protected function renderChildren() {
		$r = '';
		
		foreach ($this->children() AS $child) {
			$r .= $child . PHP_EOL;
		}
		
		return $r;
	}
	
	
	/**
	 * @implements \nexxes\widgets\WidgetInterface
	 */
	public function getDescendants($filterByType = null) {
		$descendants = [];
		
		foreach ($this->children() AS $child) {
			if (is_null($filterByType) || ($child instanceof $filterByType)) {
				$descendants[] = $child;
			}
			
			$descendants = \array_merge($descendants, $child->getDescendants($filterByType));
		}
		
		return $descendants;
	}
	
	
	/**
	 * The HTML tag to use for this container, defaults to DIV
	 * @var string
	 */
	private $WidgetContainerTraitType;
	
	/**
	 * Return the HTML tag for this container
	 * 
	 * @return string
	 */
	public function getType() {
		return (
			$this->WidgetContainerTraitType !== null
			? $this->WidgetContainerTraitType
			: (
					$this->validTypes() !== null
					? $this->validTypes()[0]
					: 'div'
				)
		);
	}
	
	/**
	 * Change the used tag for this container
	 * 
	 * @param string $newType
	 * @return \nexxes\widgets\WidgetContainer $this for chaining
	 */
	public function setType($newType) {
		if (($this->validTypes() !== null) && !\in_array($newType, $this->validTypes())) {
			throw new \UnexpectedValueException('Invalid tag "' . $newType . '" for class "' . static::class . '", valid tags are: ' . \implode(', ', $this->validTypes()));
		}
		
		if ($this->WidgetContainerTraitType !== $newType) {
			$this->WidgetContainerTraitType = $newType;
			$this->setChanged(true);
		}
		
		return $this;
	}
	
	/**
	 * @return array<String> List of valid tags nor NULL for no restriction
	 */
	protected function validTypes() {
		return null;
	}
}
