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
 * Description of ScriptLink
 *
 * @author dennis
 */
class ScriptLink implements ScriptInterface
{

    /**
     * The url of the style sheet
     * @var string
     */
    private $url = null;

    /**
     * @param string $url
     * @return \Replum\Html\StyleSheetLink $this for chaining
     */
    public function setUrl($url)
    {
        $this->url = $url;
        return $this;
    }

    public function __toString()
    {
        return '<script src="' . \htmlentities($this->url, null, 'UTF-8') . '?t=' . time() . '"></script>';
    }
}
