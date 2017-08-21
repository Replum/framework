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

use \Replum\WidgetInterface;
use \Replum\WidgetTrait;

/**
 * @author Dennis Birkholz <dennis@birkholz.org>
 */
class Image extends HtmlElement
{
    /**
     * The src URL of this image
     * @var string
     */
    private $source;

    /**
     * @return string
     */
    public function getSource()
    {
        return $this->source;
    }

    /**
     * @param string $newSource
     * @return \Replum\Html\Image $this for chaining
     */
    public function setSource($newSource)
    {
        if ($this->source !== $newSource) {
            $this->source = $newSource;
            $this->setChanged(true);
        }

        return $this;
    }

    public function __toString()
    {
        return '<img src="' . $this->escape($this->getSource()) . '"' . $this->renderAttributes() . ' />';
    }
}
