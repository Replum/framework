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
 * Represents a script definition to embedd in the HEAD of an html document.
 */
interface ScriptInterface
{
    /**
     * Create an html string to put into the HEAD of a document
     */
    function __toString();
}
