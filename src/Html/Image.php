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

use \Replum\PageInterface;
use \Replum\Util;

/**
 * @author Dennis Birkholz <dennis@birkholz.org>
 */
final class Image extends HtmlElement
{
    const TAG = 'img';

    /**
     * The src URL of this image
     * @var string
     */
    private $source;

    /**
     */
    public function getSource() : string
    {
        return $this->source;
    }

    /**
     */
    public function hasSource() : bool
    {
        return ($this->source !== null);
    }

    /**
     * @return $this
     */
    public function setSource(string $newSource) : self
    {
        if ($this->source !== $newSource) {
            $this->source = $newSource;
            $this->setChanged(true);
        }

        return $this;
    }

    public function render() : string
    {
        return '<' . self::TAG
            . Util::renderHtmlAttribute('src', $this->source)
            . $this->renderAttributes()
            . ' />';
    }

    public static function create(PageInterface $page, string $source = null) : self
    {
        $image = new self($page);
        if ($source !== null) {
            $image->setSource($source);
        }
        return $image;
    }
}
