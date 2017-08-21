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

use \Replum\WidgetCollection;
use \Replum\WidgetTrait;

/**
 * @author Dennis Birkholz <dennis@birkholz.org>
 * @link http://www.w3.org/TR/html5/tabular-data.html#htmltablesectionelement
 */
trait TableSectionTrait
{
    use WidgetTrait;

    /**
     * @return array<\Replum\WidgetInterface>
     */
    protected function getUnfilteredChildren()
    {
        return ($this->TableSectionTraitRows ? $this->TableSectionTraitRows->toArray() : []);
    }

    /**
     * @var WidgetCollection
     */
    private $TableSectionTraitRows;

    /**
     * @implements TableSectionInterface
     * {@inheritdoc}
     */
    public function rows()
    {
        if (is_null($this->TableSectionTraitRows)) {
            $this->TableSectionTraitRows = new WidgetCollection($this, false);
        }

        return $this->TableSectionTraitRows;
    }

    protected function renderTableSection($tag)
    {
        $r = '<' . $tag . $this->renderAttributes() . '>' . PHP_EOL;

        foreach ($this->rows() as $row) {
            $r .= $row;
        }

        $r .= '</' . $tag . '>' . PHP_EOL;
        return $r;
    }
}
