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

/**
 * A ValueTranslator converts data between the native (database) representation and the presentation representation
 *
 * @author Dennis Birkholz <dennis@birkholz.org>
 */
interface ValueTranslatorInterface
{
    const CHARSET = 'UTF-8';

    /**
     * Validates the unsafe user supplied string and and normalizes it to a format that can be used by import() to convert it to the native (storage) format.
     *
     * @throws ValueTranslationException
     */
    function normalize(string $value) : string;

    /**
     * Convert the normalized validated user input string to the native (storable) format
     */
    function import(string $value);

    /**
     * Convert the native value to the presentation value, e.g. to display on a form
     */
    function export($value) : string;

    /**
     * Compare two native values for sorting
     */
    function compare($value1, $value2) : int;
}
