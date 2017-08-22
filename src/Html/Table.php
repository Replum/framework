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
 * @link http://www.w3.org/TR/html5/tabular-data.html#the-table-element
 */
class Table implements WidgetInterface
{
    use WidgetTrait;

    protected function getUnfilteredChildren()
    {
        return \array_merge([$this->header], ($this->bodies ? $this->bodies->toArray() : []), [$this->footer]);
    }

    /**
     * @var TableHeader
     */
    private $header;

    public function getHeader()
    {
        return $this->header;
    }

    public function setHeader(TableHeader $newHeader)
    {
        $this->header = $newHeader;
        return $this;
    }

    /**
     * @var TableFooter
     */
    private $footer;

    public function getFooter()
    {
        return $this->footer;
    }

    public function setFooter(TableFooter $newFooter)
    {
        $this->footer = $newFooter;
        return $this;
    }

    /**
     * @var \Replum\WidgetCollection
     */
    private $bodies;

    public function bodies()
    {
        if (is_null($this->bodies)) {
            $this->bodies = new WidgetCollection($this, false);
        }

        return $this->bodies;
    }

    public function __toString()
    {
        $r = '<table' . $this->renderAttributes() . '>' . PHP_EOL;

        if (!is_null($this->getHeader())) {
            $r .= $this->getHeader();
        }

        if (!is_null($this->getFooter())) {
            $r .= $this->getFooter();
        }

        foreach ($this->bodies() as $body) {
            $r .= $body;
        }

        $r .= '</table>' . PHP_EOL;

        return $r;
    }
}