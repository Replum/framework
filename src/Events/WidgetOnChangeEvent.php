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
final class WidgetOnChangeEvent extends WidgetEvent
{
    const NAME = 'change';

    /**
     * @var string
     */
    private $oldValue;

    public function getOldValue() : string
    {
        return $this->oldValue;
    }

    /**
     * @var string
     */
    private $newValue;

    public function getNewValue() : string
    {
        return $this->newValue;
    }

    public function __construct(WidgetInterface $widget, string $oldValue, string $newValue)
    {
        parent::__construct($widget);
        $this->oldValue = $oldValue;
        $this->newValue = $newValue;
    }
}
