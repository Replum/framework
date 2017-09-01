<?php
/**
 * This file is part of Replum: the web widget framework.
 *
 * Copyright (c) Dennis Birkholz <dennis@birkholz.org>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Replum\Html\Attributes;

use Replum\Util;

/**
 * @link https://www.w3.org/TR/html5/embedded-content-0.html#attr-dim-width
 * @link https://www.w3.org/TR/html5/embedded-content-0.html#attr-dim-height
 */
trait HeightWidthAttributesTrait
{
    /**
     * Horizontal dimension
     *
     * @var int
     */
    private $width;

    /**
     * Get the horizontal dimension
     */
    final public function getWidth() : int
    {
        return $this->width;
    }

    /**
     * Check whether the horizontal dimension is set
     */
    final public function hasWidth() : bool
    {
        return ($this->width !== null);
    }

    /**
     * Set the horizontal dimension
     *
     * @return static $this
     */
    final public function setWidth(int $width = null) : self
    {
        if ($this->width !== $width) {
            $this->width = $width;
            $this->setChanged(true);
        }
        return $this;
    }

    /**
     * Vertical dimension
     *
     * @var int
     */
    private $height;

    /**
     * Get the vertical dimension
     */
    final public function getHeight() : int
    {
        return $this->height;
    }

    /**
     * Check whether the vertical dimension is set
     */
    final public function hasHeight() : bool
    {
        return ($this->height !== null);
    }

    /**
     * Set the vertical dimension
     *
     * @return static $this
     */
    final public function setHeight(int $height = null) : self
    {
        if ($this->height !== $height) {
            $this->height = $height;
            $this->setChanged(true);
        }
        return $this;
    }

    final protected function renderHeightWidthAttributes() : string
    {
        return Util::renderHtmlAttribute('height', $this->height)
            . Util::renderHtmlAttribute('width', $this->width)
        ;
    }
}