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

final class PhoneTranslator implements ValueTranslatorInterface
{
    private $countryPrefix = '+49';


    /**
     * Set the country prefix to use when normalizing the phone number
     *
     * @return static $this
     */
    public function setCountryPrefix(string $countryPrefix) : self
    {
        $this->countryPrefix = $countryPrefix;
        return $this;
    }

    /**
     * @see ValueTranslatorInterface::normalize()
     */
    public function normalize(string $value): string
    {
        // Format is e.g. "+49 123 12 345 6789" converted to "+49 123 12 345 6789"
        if (\preg_match('/^(\+[0-9]+)(([ ]+[0-9]+)*)$/', $value, $matches)) {
            return $matches[0];
        }

        // Format is e.g. "0123 12 345-678 - 9" converted to "+49 123 123456789"
        if (\preg_match('/^0([1-9][0-9]+)(([- ]+[0-9]+)*)$/', $value, $matches)) {
            return $this->countryPrefix . ' ' . $matches[1] . (isset($matches[2]) && $matches[2] !== '' ? ' ' . \str_replace(['-', ' '], ['', ''], $matches[2]) : '') ;
        }

        throw new ValueTranslationException('Invalid phone number format');
    }

    /**
     * @see ValueTranslatorInterface::import()
     */
    public function import(string $value)
    {
        return ($value === '' ? null : $value);
    }

    /**
     * @see ValueTranslatorInterface::export()
     */
    public function export($value): string
    {
        return ($value === null ? '' : $value);
    }

    /**
     * @see ValueTranslatorInterface::compare()
     */
    function compare($a, $b): int
    {
        if ($a === null) { return 1; }
        if ($b === null) { return -1; }

        return \strcoll($a, $b);
    }
}
