<?php

/*
 * This file is part of Replum: the web widget framework.
 *
 * Copyright (c) Dennis Birkholz <dennis@birkholz.org>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Replum;

interface StringTranslatorInterface
{
    /**
     * Translate the supplied string to the preconfigured target language.
     *
     * @param string $str
     * @return string
     */
    function translate($str);
}
