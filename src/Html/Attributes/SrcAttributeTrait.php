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

use \Replum\Util;

/**
 * @link https://www.w3.org/TR/html5/embedded-content-0.html#attr-iframe-src
 * @link https://www.w3.org/TR/html5/embedded-content-0.html#attr-img-src
 */
trait SrcAttributeTrait
{
    /**
     * Address of the resource
     * @var string
     */
    private $src;

    /**
     * Get the Address of the resource
     */
    final public function getSrc() : string
    {
        return $this->src;
    }

    /**
     * Check whether the address of the resource is set
     */
    final public function hasSrc() : bool
    {
        return ($this->src !== null);
    }

    /**
     * Set the address of the resource
     *
     * @return static $this
     */
    final public function setSrc(string $src = null) : self
    {
        if ($this->src !== $src) {
            $this->src = $src;
            $this->setChanged(true);
        }
        return $this;
    }

    final protected function renderSrcAttribute() : string
    {
        return Util::renderHtmlAttribute('src', $this->src);
    }
}
