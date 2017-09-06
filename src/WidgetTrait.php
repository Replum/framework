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
    ######################################################################
    # Page handling                                                      #
    ######################################################################

    /**
     * @see \Replum\WidgetInterface::getPage()
     * @throws \Replum\WidgetDetachedException
     */
    final public function getPage() : PageInterface
    {
        // Widget is the page itself
        if ($this instanceof Page) {
            return $this;
        }

        // Widget is detached
        elseif ($this->widgetTraitParent === null) {
            throw new WidgetDetachedException();
        }

        else {
            return $this->widgetTraitParent->getPage();
        }
    }

    /**
     * @return bool
     */
    final public function isDetached() : bool
    {
        // Widget is page so not detached
        if ($this instanceof Page) {
            return false;
        }

        // Widget has no parent so is detached obviously
        elseif ($this->widgetTraitParent === null) {
            return true;
        }

        else {
            return $this->widgetTraitParent->isDetached();
        }
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
        if ($this->widgetId === null) {
            $this->widgetId = Util::randomString(16);
        }

        return $this->widgetId;
    }

    /**
     * Set the widget id if the constructor template can not be used
     *
     * @return static $this
     */
    final protected function setWidgetId(string $widgetId) : WidgetInterface
    {
        if ($this->widgetId !== null && $this->widgetId !== $widgetId) {
            $this->getPage()->changeWidgetId($this, $this->widgetId, $widgetId);
        }
        $this->widgetId = $widgetId;
        return $this;
    }

    ######################################################################
    # Hierarchy handling                                                 #
    ######################################################################

    /**
     * @var \Replum\WidgetInterface
     */
    private $widgetTraitParent = null;

    /**
     * @see \Replum\WidgetInterface::clearParent()
     */
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
     * @see \Replum\WidgetInterface::getParent()
     */
    final public function getParent() : WidgetInterface
    {
        if ($this->widgetTraitParent === null) {
            throw new \InvalidArgumentException('No parent exists for this widget!');
        }

        return $this->widgetTraitParent;
    }

    /**
     * @see \Replum\WidgetInterface::hasParent()
     */
    final public function hasParent() : bool
    {
        return ($this->widgetTraitParent !== null);
    }

    /**
     * @see \Replum\WidgetInterface::isRoot()
     */
    final public function isRoot() : bool
    {
        return ($this instanceof PageInterface);
    }

    /**
     * @see \Replum\WidgetInterface::setParent()
     */
    final public function setParent(WidgetInterface $newParent = null) : WidgetInterface
    {
        // Avoid recursion
        if ($this->widgetTraitParent === $newParent) {
            return $this;
        }

        // Remove from old parent
        $this->clearParent();

        // Add to new parent
        $this->widgetTraitParent = $newParent;

        if ($newParent instanceof WidgetContainerInterface) {
            $newParent->add($this);
        }

        $this->setChanged(true);

        $this->getParent()->dispatch(new WidgetAddEvent($this->getParent(), $this));

        return $this;
    }

    /**
     * Get the nearest anchestor of the supplied type
     *
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
     * @return \Traversable<WidgetInterface>
     * @see \Replum\WidgetInterface::getAncestors()
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
     * @see \Replum\WidgetInterface::on()
     */
    final public function on(string $eventName, callable $listener, int $priority = 50) : WidgetInterface
    {
        if (is_null($this->eventDispatcher)) {
            $this->eventDispatcher = new EventDispatcher();
        }

        $this->eventDispatcher->addListener($eventName, $listener, $priority);
        return $this;
    }

    /**
     * @see \Replum\WidgetInterface::one()
     */
    final public function one(string $eventName, callable $listener, int $priority = 50) : WidgetInterface
    {
        return $this->on($eventName, new EventHandlerCallOnceWrapper($listener), $priority);
    }

    /**
     * @see \Replum\WidgetInterface::off()
     */
    final public function off(string $eventName = null, callable $listener = null) : WidgetInterface
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
     * @param string $eventName
     * @param array $registeredListeners List of available listeners
     * @param callable $listener
     */
    final private function removeListenerIfExists(string $eventName, $registeredListeners, callable $listener)
    {
        foreach ($registeredListeners as $existingListener) {
            if (
                ($listener === null)
                || ($existingListener === $listener)
                || (($existingListener instanceof EventHandlerCallOnceWrapper) && ($existingListener->wraps($listener)))
            ) {
                $this->eventDispatcher->removeListener($eventName, $listener);
            }
        }
    }

    /**
     * @see \Replum\WidgetInterface::dispatch()
     */
    final public function dispatch(WidgetEvent $event, string $eventName = null) : WidgetInterface
    {
        if ($eventName === null) {
            $eventName = \get_class($event);
        }

        //echo "Dispatching event $eventName at object #" . $this->getWidgetId() . " (" . \get_class($this) . ")<br>\n";

        if ($this->eventDispatcher !== null) {
            if (!$event->isPropagationStopped()) { $this->eventDispatcher->dispatch($eventName, $event); }
            if (!$event->isPropagationStopped()) { $this->eventDispatcher->dispatch('*', $event); }
        }

        if ($this->hasParent() && !$event->isPropagationStopped()) {
            $this->getParent()->dispatch($event, $eventName);
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
}
