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
 * Represents a <link rel="stylesheet"> element in the head of an html page
 */
class StyleSheetLink implements StyleSheetInterface
{
    /**
     * Stylesheet is prefered or alternate style sheet
     * @var boolean
     */
    private $alternate = false;

    /**
     * @param boolean $alternate
     * @return \Replum\Html\StyleSheetLink $this for chaining
     */
    public function setAlternate($alternate = true)
    {
        $this->alternate = $alternate;
        return $this;
    }

    /**
     * The title of the style sheet
     * @var string
     */
    private $title = null;

    /**
     * @param string $title
     * @return \Replum\Html\StyleSheetLink $this for chaining
     */
    public function setTitle($title)
    {
        $this->title = $title;
        return $this;
    }

    /**
     * Type of the style sheet
     * @var string
     */
    private $type = "text/css";

    /**
     * @param string $type
     * @return \Replum\Html\StyleSheetLink $this for chaining
     */
    public function setType($type)
    {
        $this->type = $type;
        return $this;
    }

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
        return '<link'
        . ' rel="' . ($this->alternate && $this->title ? 'alternate ' : '') . 'stylesheet"'
        . ($this->title ? ' title="' . \htmlentities($this->title, null, 'UTF-8') . '"' : '')
        . ($this->url ? ' href="' . \htmlentities($this->url, null, 'UTF-8') . '?t=' . time() . '"' : '')
        . ($this->type ? ' type="' . \htmlentities($this->type, null, 'UTF-8') . '"' : '')
        . ' />';
    }
}
