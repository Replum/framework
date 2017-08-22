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
 * A WidgetContainer holds an ordered collection (list) of widgets.
 * All children are rendered in the stored order.
 * The WidgetContainer may arrange the children in a specific visual order (e.g. rows or columns).
 * The difference between a container and a composite is that the container can hold any children whereas the composite is always assembled of the same set of child widgets.
 */
interface WidgetContainerInterface extends WidgetInterface
{
    /**
     * Add a widget to this container, making this container the parent of the widget.
     * If the widget already exists, no error is raised.
     *
     * @return $this
     */
    function add(WidgetInterface $widget) : self;

    /**
     * Remove the supplied widget from the container. If the widget does not exists, an exception is thrown.
     *
     * @return $this
     */
    function del(WidgetInterface $widget) : self;
    
    /**
     * Return the list of all widgets below this widget in the tree.
     * The returned list is not ordnered in a specific way.
     * If $filterByType is supplied, only elements that are an instance of this type are returned.
     *
     * @param string $filterByType
     * @return array<self>
     */
    function getDescendants($filterByType = null);

    /**
     * Search the widget tree for a widget with the supplied ID.
     *
     * @param string $id
     * @return self|null
     */
    function findById($id);

    /**
     * Get the list of children of this container.
     * @return WidgetCollection
     */
    function children();
}
