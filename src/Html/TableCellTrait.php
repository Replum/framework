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

/**
 * Default implementation of the TableCellInterface
 *
 * @author Dennis Birkholz <dennis@birkholz.org>
 */
trait TableCellTrait
{
    /**
     * @var int
     */
    private $TableCellTraitColSpan = 1;

    /**
     * @implements TableCellInterface
     * {@inheritdoc}
     */
    public function getColSpan()
    {
        return $this->TableCellTraitColSpan;
    }

    /**
     * @implements TableCellInterface
     * {@inheritdoc}
     */
    public function setColSpan($newColSpan)
    {
        if (!\is_int($newColSpan)) {
            throw new \InvalidArgumentException('Colspan must be an integer.');
        }

        if ($newColSpan < 1) {
            throw new \InvalidArgumentException('Colspan must be an integer >= 1.');
        }

        $this->TableCellTraitColSpan = (int) $newColSpan;
        return $this;
    }

    /**
     * @var int
     */
    private $TableCellTraitRowSpan = 1;

    /**
     * @implements TableCellInterface
     * {@inheritdoc}
     */
    public function getRowSpan()
    {
        return $this->TableCellTraitRowSpan;
    }

    /**
     * @implements TableCellInterface
     * {@inheritdoc}
     */
    public function setRowSpan($newRowSpan)
    {
        if (!\is_int($newRowSpan)) {
            throw new \InvalidArgumentException('Colspan must be an integer.');
        }

        if ($newRowSpan < 1) {
            throw new \InvalidArgumentException('Colspan must be an integer >= 1.');
        }

        $this->TableCellTraitRowSpan = (int) $newRowSpan;
        return $this;
    }

    protected function renderTableCellAttributes()
    {
        return
        ($this->getColSpan() > 1 ? ' colspan=' . $this->getColSpan() : '')
        . ($this->getRowSpan() > 1 ? ' rowspan=' . $this->getRowSpan() : '')
        ;
    }
}