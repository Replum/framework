<?php
/**
 * This file is part of Replum: the web widget framework.
 *
 * Copyright (c) Dennis Birkholz <dennis@birkholz.org>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Replum\Forms;

final class IntegerTranslator implements ValueTranslatorInterface
{
    /**
     * @var int
     */
    private $min;

    /**
     * @var int
     */
    private $max;


    /**
     * Set or clear the minimum value required
     *
     * @return static $this
     */
    public function setMin(int $min = null) : self
    {
        if ($min !== null && $this->max !== null && $this->max < $min) {
            throw new \InvalidArgumentException("Required minimum must not exceed allowed maximum!");
        }

        $this->min = $min;
        return $this;
    }


    /**
     * Set or clear the maximum value allowed
     *
     * @return static $this
     */
    public function setMax(int $max = null) : self
    {
        if ($max !== null && $this->min !== null && $max < $this->min) {
            throw new \InvalidArgumentException("Allowed maximum must not undercut required minimum!");
        }

        $this->max = $max;
        return $this;
    }

    /**
     * @see ValueTranslatorInterface::normalize()
     */
    public function normalize(string $value): string
    {
        $filteredValue = \filter_var($value, \FILTER_VALIDATE_INT);

        if ($filteredValue === false) {
            throw new ValueTranslationException('Supplied value must be a valid integer!');
        }

        if ($this->min !== null && $filteredValue < $this->min) {
            throw new ValueTranslationException('Supplied value must be at least ' . $this->min . '!');
        }

        if ($this->max !== null && $this->max < $filteredValue) {
            throw new ValueTranslationException('Supplied value must not exceed ' . $this->max . '!');
        }

        return "$filteredValue";
    }

    /**
     * @see ValueTranslatorInterface::import()
     */
	public function import(string $value)
    {
        return ($value === '' ? null : (int)$value);
	}

    /**
     * @see ValueTranslatorInterface::export()
     */
    public function export($value) : string
    {
        return ($value === null ? '' : "$value");
    }

    /**
     * @see ValueTranslatorInterface::compare()
     */
    public function compare($a, $b) : int
    {
        return ($a < $b ? -1 : 1);
    }
}
