<?php

/*
 * This file is part of the nexxes/widgets-html package.
 *
 * Copyright (c) Dennis Birkholz, nexxes Informationstechnik GmbH <dennis.birkholz@nexxes.net>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace nexxes\widgets\html;

use \nexxes\widgets\WidgetInterface;
use \nexxes\widgets\WidgetTrait;

/**
 * @author Dennis Birkholz <dennis.birkholz@nexxes.net>
 */
class Image implements WidgetInterface
{
    use WidgetTrait;

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
     * @return \nexxes\widgets\html\Image $this for chaining
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
