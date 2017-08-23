<?php

/*
 * This file is part of Replum: the web widget framework.
 *
 * Copyright (c) Dennis Birkholz <dennis@birkholz.org>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Replum;

use \Replum\Events\EventHandlerCallOnceWrapper;
use \Replum\Events\WidgetEvent;
use \Replum\Events\WidgetAddEvent;
use \Replum\Events\WidgetChangeEvent;
use \Replum\Events\WidgetRemoveEvent;
use \Symfony\Component\EventDispatcher\EventDispatcherInterface;
use \Symfony\Component\EventDispatcher\EventDispatcher;

/**
 * Default implementation of WidgetInterface
 *
 */
trait WidgetTrait
{
    public function __construct(PageInterface $page)
    {
        $this->setPage($page);

        $widgetId = $this->getPage()->registerWidget($this);
        $this->setWidgetId($widgetId);
    }

    ######################################################################
    # Page handling                                                      #
    ######################################################################

    /**
     * @var \Replum\PageInterface
     */
    private $widgetTraitPage = null;

    /**
     * @see \Replum\WidgetInterface::getPage()
     */
    final public function getPage() : PageInterface
    {
        return $this->widgetTraitPage;
    }

    /**
     * Set the page if the constructor template can not be used
     */
    final protected function setPage(PageInterface $page) : WidgetInterface
    {
        $this->widgetTraitPage = $page;
        return $this;
    }

    ######################################################################
    # Widget ID handling                                                 #
    ######################################################################

    /**
     * @var string
     */
    private $widgetId;

    /**
     * @see WidgetInterface::getWidgetId()
     */
    final public function getWidgetId() : string
    {
        return $this->widgetId;
    }

    /**
     * Set the widget id if the constructor template can not be used
     */
    final protected function setWidgetId(string $widgetId) : WidgetInterface
    {
        if ($this->widgetId !== null && $this->widgetId !== $widgetId) {
            $this->getPage()->changeWidgetId($this, $this->widgetId, $widgetId);
        }
        $this->widgetId = $widgetId;
        return $this;
    }

    /**
     * @var \Replum\WidgetInterface
     */
    private $widgetTraitParent = null;

    /**
     * @see \Replum\WidgetInterface::isRoot()
     */
    public function isRoot() : bool
    {
        return (($this instanceof PageInterface) || is_null($this->widgetTraitParent));
    }

    /**
     * @see \Replum\WidgetInterface::getParent()
     */
    public function getParent() : WidgetInterface
    {
        if (is_null($this->widgetTraitParent)) {
            throw new \InvalidArgumentException('No parent exists for this widget!');
        }

        return $this->widgetTraitParent;
    }

    /**
     * Get the nearest anchestor of the supplied type
     *
     * @param string $type
     * @return null|object
     */
    public function getNearestAncestor(string $type)
    {
        foreach ($this->getAncestors($type) as $ancestor) {
            return $ancestor;
        }

        return null;
    }

    /**
     * @see \Replum\WidgetInterface::getAncestors()
     * @returns \Traversable<WidgetInterface>
     */
    public function getAncestors(string $filterByType = null) : \Traversable
    {
        if ($this->isRoot()) { return; }

        if (is_null($filterByType) || ($this->getParent() instanceof $filterByType)) {
            yield $this->getParent();
        }

        foreach ($this->getParent()->getAncestors($filterByType) as $ancestor) {
            yield $ancestor;
        }
    }

    /**
     * @see \Replum\WidgetInterface::setParent()
     */
    public function setParent(WidgetInterface $newParent) : WidgetInterface
    {
        // Avoid recursion
        if ($this->widgetTraitParent === $newParent) {
            return $this;
        }

        // Remove from old parent
        $this->clearParent();

        // Add to new parent
        $this->widgetTraitParent = $newParent;
        $this->setChanged(true);

        // Add to parent if it is a widget container (not for composites!)
        if (($newParent instanceof WidgetContainerInterface) && (!$newParent->children()->contains($this))) {
            $newParent->children()[] = $this;
        }

        $this->getParent()->dispatch(new WidgetAddEvent($this->getParent(), $this));

        return $this;
    }

    public function clearParent() : WidgetInterface
    {
        // Prevent recursion
        if ($this->widgetTraitParent === null) {
            return $this;
        }

        $oldParent = $this->widgetTraitParent;
        $this->widgetTraitParent = null;

        if (($oldParent instanceof WidgetContainerInterface) && ($oldParent->children()->contains($this))) {
            $oldParent->children()->remove($this);
        }

        $oldParent->dispatch(new WidgetRemoveEvent($oldParent, $this));
        $this->setChanged();

        return $this;
    }

    /**
     * @see \Replum\WidgetInterface::getRoot()
     */
    public function getRoot() : bool
    {
        if ($this->isRoot()) {
            return $this;
        } else {
            return $this->getParent()->getRoot();
        }
    }

    /**
     * @var boolean
     */
    private $widgetTraitChanged = true;

    /**
     * @see \Replum\WidgetInterface::isChanged()
     */
    public function isChanged() : bool
    {
        return $this->widgetTraitChanged;
    }

    /**
     * @see \Replum\WidgetInterface::setChanged()
     */
    public function setChanged(bool $changed = true) : WidgetInterface
    {
// Nothing new here
        if ($changed === $this->widgetTraitChanged) {
            return $this;
        }

        $this->widgetTraitChanged = $changed;
        $this->dispatch(new WidgetChangeEvent($this));

        return $this;
    }

    /**
     * On restoring the widget on a successive call, mark it as unchanged
     */
    public function __wakeup()
    {
        $this->widgetTraitChanged = false;
    }

    /**
     * Verify the supplied name is a valid xml attribute name
     *
     * @param string $name
     * @return boolean
     * @link http://www.w3.org/TR/xml/#NT-Name
     */
    protected function validateAttributeName($name)
    {
        $nameStartChar = ':|[A-Z]|_|[a-z]|[\xC0-\xD6]|[\xD8-\xF6]|[\xF8-\x{2FF}]|[\x{370}-\x{37D}]|[\x{37F}-\x{1FFF}]|[\x{200C}-\x{200D}]|[\x{2070}-\x{218F}]|[\x{2C00}-\x{2FEF}]|[\x{3001}-\x{D7FF}]|[\x{F900}-\x{FDCF}]|[\x{FDF0}-\x{FFFD}]';
        // |[\x{10000}-\x{EFFFF}] must be appended according to the ref but is invalid in PHP/PCRE
        $nameChar = $nameStartChar . '|-|.|[0-9]|\xB7|[\x{0300}-\x{036F}]|[\x{203F}-\x{2040}]';

        return \preg_match('/^(' . $nameStartChar . ')(' . $nameChar . ')*$/u', $name);
    }

    /**
     * Render all common Widget attributes
     *
     * @return string
     * @codeCoverageIgnore
     */
    protected function renderWidgetAttributes()
    {
        //\sort($this->widgetTraitClasses);

        //if (($this->eventDispatcher !== null) || $this->widgetTraitNeedId) {
        //    $this->getID();
        //}

        return
            ($this->hasID() ? '' . Util::renderHtmlAttribute('id', $this->getID()) : '')
            . Util::renderHtmlAttribute('class', $this->getClasses())
        /*. $this->renderDataAttributes()
        . $this->renderHtmlAttribute('role', $this->widgetTraitRole)
        . $this->renderHtmlAttribute('title', $this->widgetTraitTitle)
        . $this->renderHtmlAttribute('tabindex', $this->widgetTraitTabindex)*/
        ;
    }

    /**
     * Render all attributes of the current widget.
     * Default implementation, override in concrete implementations.
     * Include renderWidgetAttributes() instead of renaming renderAttributes() when using the trait.
     *
     * @return string
     */
    protected function renderAttributes()
    {
        return $this->renderWidgetAttributes();
    }

    ######################################################################
    #
    # Event handling
    #
    ######################################################################

    /**
     * @var EventDispatcherInterface
     */
    private $eventDispatcher;

    /**
     * @return static $this for chaining
     * @see \Replum\WidgetInterface::on()
     */
    public function on($eventName, callable $listener, $priority = 50)
    {
        if (is_null($this->eventDispatcher)) {
            $this->eventDispatcher = new EventDispatcher();
        }

        $this->eventDispatcher->addListener($eventName, $listener, $priority);
        return $this;
    }

    /**
     * @return static $this for chaining
     * @see \Replum\WidgetInterface::one()
     */
    public function one($eventName, callable $listener, $priority = 50)
    {
        return $this->on($eventName, new EventHandlerCallOnceWrapper($listener), $priority);
    }

    /**
     * @return static $this for chaining
     * @see \Replum\WidgetInterface::off()
     */
    public function off($eventName = null, callable $listener = null)
    {
        if (is_null($this->eventDispatcher)) {
            return $this;
        }

        // Cleanup all handlers
        if (($eventName === null) && ($listener === null)) {
            $this->eventDispatcher = null;
        } elseif ($eventName === null) {
            foreach ($this->eventDispatcher->getListeners() as $eventName => $listeners) {
                $this->removeListenerIfExists($eventName, $listeners, $listener);
            }
        } else {
            $this->removeListenerIfExists($eventName, $this->eventDispatcher->getListeners($eventName), $listener);
        }

        return $this;
    }

    /**
     * Helper function to remove all listeners for a specific event.
     *
     * @param string $eventName
     * @param array $listeners List of available listeners
     * @param callable $listener
     */
    private function removeListenerIfExists($eventName, $listeners, $listener)
    {
        foreach ($listeners as $existingListener) {
            if (
            ($listener === null) || ($existingListener === $listener) || (($existingListener instanceof EventHandlerCallOnceWrapper) && ($existingListener->wraps($listener)))
            ) {
                $this->eventDispatcher->removeListener($eventName, $listener);
            }
        }
    }

    /**
     * @see \Replum\WidgetInterface::dispatch()
     */
    public function dispatch(WidgetEvent $event, $eventName = null)
    {
        if ($eventName === null) {
            $eventName = \get_class($event);
        }

        if (!$this->isRoot() && ($this->getPage() !== null)) {
            if (!$event->isPropagationStopped()) { $this->getPage()->dispatch($event, '*'); }
            if (!$event->isPropagationStopped()) { $this->getPage()->dispatch($event); }
        }

        if ($this->eventDispatcher !== null) {
            if (!$event->isPropagationStopped()) { $this->eventDispatcher->dispatch('*', $event); }
            if (!$event->isPropagationStopped()) { $this->eventDispatcher->dispatch($eventName, $event); }
        }

        return $this;
    }

    ######################################################################
    #
    # Bag key/value store
    #
    ######################################################################

    /**
     * @var \ArrayObject
     */
    private $bag;

    /**
     * @see \Replum\WidgetInterface::getBag()
     */
    public function getBag()
    {
        if (!isset($this->bag)) {
            $this->bag = new \ArrayObject();
        }
        return $this->bag;
    }

    /**
     * Detault factory method to create a new instance
     *
     * @param WidgetInterface $parent The new parent
     * @param mixed ...$args Pairs of property names and values to apply to the new instance
     * @return static New instance
     */
    /*public static function create(WidgetInterface $parent = null)
    {
        $widget = new static($parent);
        $widget->applyArguments(1, \func_get_args());
        return $widget;
    }*/

    /**
     * @param string ...$args Pairs of property names and values
     * @return static $this for chaining
     * @throws \InvalidArgumentException
     */
    public function apply($arg1 = null, $arg2 = null)
    {
        return $this->applyArguments(0, \func_get_args());
    }

    /**
     * Read value pairs from the list of arguments and treat them as property name and property value.
     * Ignore the first $stripArgs as they may contain e.g. constructor specific parameters.
     *
     * @param integer $stripArgs
     * @param array $args
     * @return static $this for chaining
     */
    protected function applyArguments($stripArgs, array $args)
    {
        if (\count($args) <= $stripArgs) { return; }

        if ((\count($args) - $stripArgs) % 2) {
            throw new \InvalidArgumentException('Require pairs of attribute names and values!');
        }

        for ($i = $stripArgs; $i < \count($args); $i+=2) {
            $propertyName = $args[$i];
            $propertyValue = $args[$i + 1];

            if ($propertyName === 'class') {
                $this->addClass($propertyValue);
            } elseif (\substr($propertyName, 0, 4) === 'data') {
                $this->setData(\lcfirst(\substr($propertyName, 4)), $propertyValue);
            } else {
                // Force setter method to be called
                $this->__set($propertyName, $propertyValue);
            }
        }

        return $this;
    }

    ######################################################################
    #
    # Helper methods to set values
    #
    ######################################################################

    /**
     * @param string $property
     * @param mixed $value
     * @return static $this for chaining
     */
    protected function setStringProperty($property, $value)
    {
        if (\is_scalar($value) || (\is_object($value) && \method_exists($value, '__toString'))) {
            $realValue = (string) $value;
        } elseif (\is_null($value)) {
            $realValue = $value;
        } else {
            throw new \InvalidArgumentException('Can not set property "' . $property . '" to something not convertable to a string.');
        }

        return $this->setPropertyValue($property, $realValue);
    }

    protected function setBooleanProperty($property, $value)
    {
        if (\is_bool($value)) {
            $realValue = $value;
        } elseif (\is_string($value) && \in_array(\strtolower($value), ['1', 'true', 'yes', 'on',])) {
            $realValue = true;
        } elseif (\is_string($value) && \in_array(\strtolower($value), ['0', 'false', 'no', 'off',])) {
            $realValue = true;
        } else {
            throw new \InvalidArgumentException('Can not set property "' . $property . '" to something not convertable to a boolean.');
        }

        return $this->setPropertyValue($property, $realValue);
    }

    protected function setPropertyValue($property, $value)
    {
        if ($this->$property !== $value) {
            $this->setChanged();
            $this->$property = $value;
        }

        return $this;
    }

    protected function renderHtmlAttribute($name, $value)
    {
        if (\is_null($value)) { return ''; }

        if (\is_array($value)) {
            if (!\count($value)) { return ''; }

            $escaped = \array_reduce($value, function ($carry, $value) {
                return ($carry ? $carry . ' ' : '') . Util::escapeHtmlAttributeValue($value);
            });
        }

        elseif (\is_bool($value) && $value) {
            return ' ' . $name;
        }

        else {
            $escaped = Util::escapeHtmlAttributeValue($value);
        }

        return ' ' . $name . '="' . $escaped . '"';
    }
}
