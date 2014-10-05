<?php

namespace nexxes\widgets\bootstrap;

use \nexxes\widgets\WidgetCompositeInterface;
use \nexxes\widgets\WidgetCompositeTrait;
use \nexxes\widgets\WidgetContainer;
use \nexxes\widgets\WidgetInterface;

/**
 * @author Dennis Birkholz <dennis.birkholz@nexxes.net>
 * @link http://getbootstrap.com/components/#navbar
 */
class Navbar implements WidgetCompositeInterface {
	use WidgetCompositeTrait;
	
	const FIXED_TOP = 1;
	const FIXED_BOTTOM = 2;
	const STATIC_TOP = 3;
	
	public function __construct(WidgetInterface $parent) {
		$this->setParent($parent);
		
		$this->childSlot('brand');
		$this->childSlot('elements');
		
		$this['elements'] = (new WidgetContainer($this))->addClass('collapse')->addClass('navbar-collapse');
		$this->getPage()->getWidgetRegistry()->register($this['elements']);
	}
	
	/**
	 * @var bool
	 * @link http://getbootstrap.com/components/#navbar-static-top
	 */
	private $position;
	
	/**
	 * Manage position changes
	 * 
	 * @param int $position One of self::FIXED_TOP, self::FIXED_BOTTOM, self::STATIC_TOP
	 * @param bool $enable Whether to use the supplied position or not
	 * @return \nexxes\widgets\bootstrap\Navbar $this for chaining
	 */
	protected function setPosition($position, $enable) {
		// New position to set
		if ($enable && ($this->position !== $position)) {
			$this->position = $position;
			$this->setChanged(true);
		}
		
		// Clear current position
		elseif (!$enable && ($this->position === $position)) {
			$this->position = null;
			$this->setChanged(true);
		}
		
		return $this;
	}
	
	
	/**
	 * @return bool
	 * @link http://getbootstrap.com/components/#navbar-fixed-top
	 */
	public function isFixedTop() {
		return ($this->position === self::FIXED_TOP);
	}
	
	/**
	 * @param bool $newFixedTop
	 * @return \nexxes\widgets\bootstrap\Navbar $this for chaining
	 * @link http://getbootstrap.com/components/#navbar-fixed-top
	 */
	public function setFixedTop($newFixedTop = true) {
		if (!is_bool($newFixedTop)) {
			throw new \UnexpectedValueException('Boolean required as parameter for ' . __METHOD__);
		}
		
		return $this->setPosition(self::FIXED_TOP, $newFixedTop);
	}
	
	
	/**
	 * @return bool
	 * @link http://getbootstrap.com/components/#navbar-fixed-bottom
	 */
	public function isFixedBottom() {
		return ($this->position === self::FIXED_BOTTOM);
	}
	
	/**
	 * @param bool $newFixedBottom
	 * @return \nexxes\widgets\bootstrap\Navbar $this for chaining
	 * @link http://getbootstrap.com/components/#navbar-fixed-bottom
	 */
	public function setFixedBottom($newFixedBottom = true) {
		if (!is_bool($newFixedBottom)) {
			throw new \UnexpectedValueException('Boolean required as parameter for ' . __METHOD__);
		}
		
		return $this->setPosition(self::FIXED_BOTTOM, $newFixedBottom);
	}
	
	
	/**
	 * @return bool
	 * @link http://getbootstrap.com/components/#navbar-static-top
	 */
	public function isStaticTop() {
		return ($this->position === self::STATIC_TOP);
	}
	
	/**
	 * @param bool $newStaticTop
	 * @return \nexxes\widgets\bootstrap\Navbar $this for chaining
	 * @link http://getbootstrap.com/components/#navbar-static-top
	 */
	public function setStaticTop($newStaticTop = true) {
		if (!is_bool($newStaticTop)) {
			throw new \UnexpectedValueException('Boolean required as parameter for ' . __METHOD__);
		}
		
		return $this->setPosition(self::STATIC_TOP, $newStaticTop);
	}
	
	
	/**
	 * @var bool
	 * @link http://getbootstrap.com/components/#navbar-inverted
	 */
	private $inverse = false;
	
	/**
	 * @return bool
	 * @link http://getbootstrap.com/components/#navbar-inverted
	 */
	public function isInverse() {
		return $this->inverse;
	}
	
	/**
	 * @param bool $inverse
	 * @return \nexxes\widgets\bootstrap\Navbar $this for chaining
	 * @link http://getbootstrap.com/components/#navbar-inverted
	 */
	public function setInverse($inverse = true) {
		if (!is_bool($inverse)) {
			throw new \UnexpectedValueException('Boolean required as parameter for ' . __METHOD__);
		}
		
		if ($this->inverse !== $inverse) {
			$this->inverse = $inverse;
			$this->setChanged(true);
		}
		
		return $this;
	}
	
	
	/**
	 * Handle synchronization of required classes
	 */
	protected function updateNavbarClasses() {
		$this->addClass('navbar');
		
		if ($this->isInverse()) {
			$this->addClass('navbar-inverse');
		} else {
			$this->addClass('navbar-default');
		}
		
		if ($this->isFixedTop()) {
			$this->addClass('navbar-fixed-top');
		} else {
			$this->delClass('navbar-fixed-top');
		}
		
		if ($this->isFixedBottom()) {
			$this->addClass('navbar-fixed-bottom');
		} else {
			$this->delClass('navbar-fixed-bottom');
		}
		
		if ($this->isStaticTop()) {
			$this->addClass('navbar-static-top');
		} else {
			$this->delClass('navbar-static-top');
		}
	}
	
	
	public function __toString() {
		$this->updateNavbarClasses();
		
		return '<nav' . $this->renderAttributes() . '>' . PHP_EOL
			. '<div class="container-fluid">' . PHP_EOL
			. '<div class="navbar-header">' . PHP_EOL
			. '<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#' . $this->escape($this['elements']->getID()) . '">' . PHP_EOL
			. '<span class="sr-only">Toggle navigation</span>' . PHP_EOL
			. '<span class="icon-bar"></span>' . PHP_EOL
			. '<span class="icon-bar"></span>' . PHP_EOL
			. '<span class="icon-bar"></span>' . PHP_EOL
			. '</button>' . PHP_EOL
      . (isset($this['brand']) ? $this['brand'] : '')
			. '</div>' . PHP_EOL
			. $this['elements']
			. '</div>' . PHP_EOL
			. '</nav>';
	}
}
