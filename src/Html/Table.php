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

use Replum\Util;
use \Replum\WidgetInterface;
use \Replum\WidgetTrait;
use \Replum\WidgetCollection;

/**
 * @author Dennis Birkholz <dennis@birkholz.org>
 * @link https://www.w3.org/TR/html5/tabular-data.html#the-table-element
 */
final class Table extends HtmlElement implements FlowElementInterface
{
    const TAG = 'table';

    ######################################################################
    # border attribute                                                   #
    ######################################################################

    /**
     * Indicates that the table element is not being used for layout purposes
     *
     * @var bool
     * @link https://www.w3.org/TR/html5/tabular-data.html#attr-table-border
     */
    private $border = false;

    /**
     * Check whether it is indicated that the table element is not being used for layout purposes
     */
    final public function getBorder() : bool
    {
        return $this->border;
    }

    /**
     * Toggle indication
     * that the table element is not being used for layout purposes
     *
     * @return static $this
     */
    final public function setBorder(bool $border) : self
    {
        if ($this->border !== $border) {
            $this->border = $border;
            $this->setChanged(true);
        }

        return $this;
    }

    ######################################################################
    # sortable attribute                                                 #
    ######################################################################

    /**
     * Enables/disables a sorting interface for the table
     *
     * @var bool
     */
    private $sortable = false;

    /**
     * Check whether a sorting interface for the table is enabled
     */
    final public function getSortable() : bool
    {
        return $this->sortable;
    }

    /**
     * Enables/disables a sorting interface for the table
     * WARNING: not implemented by most browsers, removed in HTML 5.1
     *
     * @return static $this
     */
    final public function setSortable(bool $sortable) : self
    {
        if ($this->sortable !== $sortable) {
            $this->sortable = $sortable;
            $this->setChanged(true);
        }

        return $this;
    }

    ######################################################################
    # rendering                                                          #
    ######################################################################

    protected function renderAttributes() : string
    {
        return parent::renderAttributes()
            . Util::renderHtmlAttribute('border', $this->border)
            . Util::renderHtmlAttribute('sortable', $this->sortable)
            ;
    }
}
