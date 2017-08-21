<?php

/*
 * This file is part of Replum: the web widget framework.
 *
 * Copyright (c) Dennis Birkholz <dennis@birkholz.org>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Replum\Html;

use \Replum\WidgetInterface;
use \Replum\WidgetTrait;
use \Replum\WidgetCollection;

/**
 * @author Dennis Birkholz <dennis@birkholz.org>
 * @link http://www.w3.org/TR/html5/tabular-data.html#the-tr-element
 */
class TableRow implements WidgetInterface
{
    use WidgetTrait;

    protected function getUnfilteredChildren()
    {
        return ($this->cells ? $this->cells->toArray() : []);
    }

    /**
     * @var WidgetCollection
     */
    private $cells;

    /**
     * @return WidgetCollection
     */
    public function cells()
    {
        if (is_null($this->cells)) {
            $this->cells = new WidgetCollection($this, false);
        }

        return $this->cells;
    }

    public function __toString()
    {
        $r = '<tr' . $this->renderAttributes() . '>' . PHP_EOL;

        foreach ($this->cells() as $cell) {
            $r .= $cell;
        }

        $r .= '</tr>' . PHP_EOL;
        return $r;
    }
}
