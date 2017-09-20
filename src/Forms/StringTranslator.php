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

final class StringTranslator implements ValueTranslatorInterface
{
    /**
     * @var int
     */
    private $minLength;

    /**
     * @var int
     */
    private $maxLength;

    /**
     * @var char[]
     */
    private $charWhiteList;

    /**
     * @var char[]
     */
    private $charBlackList;


    /**
     * Set the minimum number of UTF-8 chars required for this value
     *
     * @return static $this
     */
    public function setMinLength(int $minLength = null) : self
    {
        if ($minLength !== null && $this->maxLength !== null && $this->maxLength < $minLength) {
            throw new \InvalidArgumentException("Minimum length can not exceed maximum length!");
        }

        $this->minLength = $minLength;
        return $this;
    }

    /**
     * Set the maximum number of UTF-8 chars allowed for this value
     *
     * @return static $this
     */
    public function setMaxLength(int $maxLength = null) : self
    {
        if ($maxLength !== null && $this->minLength !== null && $maxLength < $this->minLength) {
            throw new \InvalidArgumentException("Maximum length can not undercut minimum length!");
        }

        $this->maxLength = $maxLength;
        return $this;
    }

    /**
     * Set the allowed chars the value can contain.
     *
     * @param $chars String containing all allowed chars or null to disable whitelist
     * @return static $this
     */
    public function setWhiteList(string $chars = null) : self
    {
        if ($chars !== null && $this->charBlackList !== null) {
            throw new \InvalidArgumentException("WhiteList and BlackList are mutually exclusive!");
        }

        $this->charWhiteList = ($chars === null || $chars === '' ? null : \preg_split('//u', $chars, null, \PREG_SPLIT_NO_EMPTY));
        return $this;
    }

    /**
     * Set the chars the value must not contain.
     *
     * @param $chars String containing all prohibited chars or null to disable blacklist
     * @return static $this
     */
    public function setBlackList(string $chars = null) : self
    {
        if ($chars !== null && $this->charWhiteList !== null) {
            throw new \InvalidArgumentException("BlackList and WhiteList are mutually exclusive!");
        }

        $this->charBlackList = ($chars === null || $chars === '' ? null : \preg_split('//u', $chars, null, \PREG_SPLIT_NO_EMPTY));
        return $this;
    }

    /**
     * @see ValueTranslatorInterface::normalize()
     */
    public function normalize(string $value) : string
    {
        if ($this->minLength !== null && \mb_strlen($value, self::CHARSET) < $this->minLength) {
            throw new ValueTranslationException(\sprintf("Value '%s' is shorter then the required minimum of %n chars.", $value, $this->minLength));
        }

        if ($this->maxLength !== null && $this->maxLength < \mb_strlen($value, self::CHARSET)) {
            throw new ValueTranslationException(\sprintf("Value '%s' is longer then the allowed maximum of %n chars.", $value, $this->maxLength));
        }

        if ($this->charWhiteList !== null && \str_replace($this->charWhiteList, '', $value) !== '') {
            throw new ValueTranslationException(\sprintf("Value '%s' contains characters not in whitelist: '%s'", $value, \implode("','", $this->charWhiteList)));
        }

        if ($this->charBlackList !== null && \str_replace($this->charBlackList, '', $value) !== $value) {
            throw new ValueTranslationException(\sprintf("Value '%s' contains characters from blacklist: '%s'", $value, \implode("','", $this->charBlackList)));
        }

        return $value;
    }

    /**
     * @see ValueTranslatorInterface::import()
     */
    function import(string $value)
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
