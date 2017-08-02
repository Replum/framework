<?php

/*
 * This file is part of Replum: the web widget framework.
 *
 * Copyright (c) Dennis Birkholz <dennis@birkholz.org>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Replum\Events;

use \Replum\WidgetInterface;

/**
 * @author Dennis Birkholz <dennis@birkholz.org>
 */
class WidgetReplaceEvent extends WidgetEvent
{
    /**
     * @var WidgetInterface
     */
    public $parent;

    /**
     * @var WidgetInterface
     */
    public $replacement;

    /**
     * @param WidgetInterface $widget
     */
    public function __construct(WidgetInterface $parent, WidgetInterface $widget, WidgetInterface $replacement)
    {
        parent::__construct($widget);
        $this->parent = $parent;
        $this->replacement = $replacement;
    }
}
