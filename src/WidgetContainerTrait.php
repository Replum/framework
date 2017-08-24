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
 * @property-read WidgetCollection $children Access the children array (collection) of this container.
 * @property-read array<WidgetInterface> $descendants All widgets below this widget in the tree.
 * @property string $tag The HTML tag to render this widget as.
 */
trait WidgetContainerTrait
{
    use WidgetTrait;

    /**
     * @var WidgetInterface[]
     */
    private $widgetContainerTraitChildren = [];

    /**
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
     * @see \Replum\WidgetInterface::getDescendants()
     */
    public function getDescendants($filterByType = null)
    {
        $descendants = [];

        foreach ($this->getChildren() AS $child) {
            if ($child === null) { continue; }

            if (is_null($filterByType) || is_a($child, $filterByType, true)) {
                $descendants[] = $child;
            }

            if ($child instanceof WidgetContainerInterface) {
                $descendants = \array_merge($descendants, $child->getDescendants($filterByType));
            }
        }

        return $descendants;
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
     * @see \Replum\WidgetInterface::findById()
     */
    public function findById($id)
    {
        if ($this->hasID() && ($this->getID() === $id)) {
            return $this;
        }

        foreach ($this->getChildren() as $child) {
            if ($child === null) { continue; }

            if (null !== ($found = $child->findById($id))) {
                return $found;
            }
        }

        return null;
    }
}
