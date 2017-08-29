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

use \Replum\Util;

/**
 * @author Dennis Birkholz <dennis@birkholz.org>
 */
final class Img extends HtmlElement
{
    const TAG = 'img';
    const EMPTY_ELEMENT = true;

    /**
     * The src URL of this image
     * @var string
     */
    private $src;

    /**
     */
    public function getSrc() : string
    {
        return $this->src;
    }

    /**
     */
    public function hasSrc() : bool
    {
        return ($this->src !== null);
    }

    /**
     * @return $this
     */
    public function setSrc(string $src) : self
    {
        if ($this->src !== $src) {
            $this->src = $src;
            $this->setChanged(true);
        }

        return $this;
    }

    protected function renderAttributes() : string
    {
        return parent::renderAttributes()
            . Util::renderHtmlAttribute('src', $this->src)
            ;
    }
}
