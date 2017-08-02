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
     * Get the list of children of this container.
     * @return WidgetCollection
     */
    public function children();
}
