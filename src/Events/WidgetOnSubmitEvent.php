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

use Replum\WidgetInterface;

/**
 * @author Dennis Birkholz <dennis@birkholz.org>
 */
final class WidgetOnSubmitEvent extends WidgetEvent
{
    const NAME = 'submit';

    /**
     * @var array
     */
    private $data;

    /**
     * Get the data submitted
     */
    public function getData() : array
    {
        return $this->data;
    }

    public function __construct(WidgetInterface $widget, array $data)
    {
        parent::__construct($widget);
        $this->data = $data;
    }
}
