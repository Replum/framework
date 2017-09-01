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
 * @link https://www.w3.org/TR/html5/embedded-content-0.html#attr-img-alt
 * @link https://www.w3.org/TR/html5/forms.html#attr-input-alt
 */
trait AltAttributeTrait
{
    /**
     * Replacement text for use when images are not available
     *
     * @var string
     */
    private $alt;

    /**
     * Get the replacement text for use when images are not available
     */
    final public function getAlt() : string
    {
        return $this->alt;
    }

    /**
     * Check whether the replacement text for use when images are not available is set
     */
    final public function hasAlt() : bool
    {
        return ($this->alt !== null);
    }

    /**
     * Set the replacement text for use when images are not available
     *
     * @return static $this
     */
    final public function setAlt(string $alt = null) : self
    {
        if ($this->alt !== $alt) {
            $this->alt = $alt;
            $this->setChanged(true);
        }
        return $this;
    }

    final protected function renderAltAttribute() : string
    {
        return Util::renderHtmlAttribute('alt', $this->alt);
    }
}