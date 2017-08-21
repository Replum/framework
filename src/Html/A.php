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

use \Replum\WidgetContainer;
use \Replum\WidgetHasClickEventInterface;
use \Replum\WidgetHasClickEventTrait;

/**
 * @author Dennis Birkholz <dennis@birkholz.org>
 * @property string $href The url to use for this link
 */
class A extends WidgetContainer implements WidgetHasClickEventInterface
{
    use WidgetHasClickEventTrait;

    protected function validTags()
    {
        return ['a'];
    }

    /**
     * @var string
     */
    private $href;

    /**
     * @return string
     */
    public function getHref()
    {
        return $this->href;
    }

    /**
     * @param string $newHref
     * @return \Replum\Html\A $this for chaining
     */
    public function setHref($newHref)
    {
        if ($newHref !== $this->href) {
            $this->href = $newHref;
            $this->setChanged(true);
        }

        return $this;
    }

    protected function renderAttributes()
    {
        return parent::renderAttributes()
        . (!\is_null($this->href) ? ' href="' . $this->escape($this->href) . '"' : '')
        ;
    }
}
