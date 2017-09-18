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

/**
 * A widget using the WidgetContainerTrait is rendered as a DIV tag by default.
 *
 * To limit the valid tags for a widget, overwrite the validTags() method and return a list of possible tags.
 * The first tag in that list is then used as the default tag (instead of DIV).
 *
 * @author Dennis Birkholz <dennis@birkholz.org>
 */
trait WidgetContainerTrait
{
    use WidgetTrait;

    /**
     * @var WidgetInterface[]
     */
    private $widgetContainerTraitChildren = [];

    /**
     * @return static $this
     * @see WidgetContainerInterface::add()
     */
    final public function add(WidgetInterface $widget) : WidgetContainerInterface
    {
        if (!isset($this->widgetContainerTraitChildren[$widget->getWidgetId()])) {
            $this->widgetContainerTraitChildren[$widget->getWidgetId()] = $widget;
            $widget->setParent($this);
        }

        return $this;
    }

    /**
     * @see WidgetContainerInterface::del()
     */
    final public function del(WidgetInterface $widget) : WidgetContainerInterface
    {
        if (!isset($this->widgetContainerTraitChildren[$widget->getWidgetId()])) {
            throw new \InvalidArgumentException('Can not delete non-existing child widget "' . $widget->getWidgetId() . '"!');
        }

        unset($this->widgetContainerTraitChildren[$widget->getWidgetId()]);
        return $this;
    }

    /**
     * @return WidgetInterface[]
     */
    public function getChildren()
    {
        return $this->widgetContainerTraitChildren;
    }

    /**
     * @see \Replum\WidgetContainerInterface::children()
     */
    public function children()
    {
        return $this->getChildren();
    }

    /**
     * Simple helper to iterate over all children and render them.
     * @return string
     */
    protected function renderChildren() : string
    {
        $r = '';

        foreach ($this->getChildren() AS $child) {
            $r .= $child->render() . PHP_EOL;
        }

        return $r;
    }

    /**
     * @see \Replum\WidgetContainerInterface::getDescendants()
     */
    final public function getDescendants(string $filterByType = null, bool $breadthFirst = false) : \Traversable
    {
        foreach ($this->getChildren() AS $child) {
            if ($child === null) { continue; }

            if ($filterByType === null || \is_a($child, $filterByType, true)) {
                yield $child;
            }

            if (!$breadthFirst && $child instanceof WidgetContainerInterface) {
                yield from $child->getDescendants($filterByType, $breadthFirst);
            }
        }

        if ($breadthFirst) {
            foreach ($this->getChildren() as $child) {
                if ($child instanceof WidgetContainerInterface) {
                    yield from $child->getDescendants($filterByType, $breadthFirst);
                }
            }
        }
    }

    /**
     * Get the nearest descendant of the supplied type
     *
     * @param string $type
     * @return null|object
     */
    public function getNearestDescendant($type)
    {
        foreach ($this->getDescendants($type) as $descendant) {
            return $descendant;
        }

        return null;
    }

    /**
     * @see \Replum\WidgetContainerInterface::findById()
     */
    public function findById($id)
    {
        foreach ($this->getChildren() as $child) {
            if ($child === null) { continue; }

            if ($child->getWidgetId() === $id) {
                return $child;
            }

            if ($child instanceof WidgetContainerInterface && ($found = $child->findById($id)) !== null) {
                return $found;
            }
        }

        return null;
    }
}
