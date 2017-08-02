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
use \Replum\PageTrait;
use \Replum\WidgetContainerTrait;

abstract class Page implements PageInterface
{
    use PageTrait,
        WidgetContainerTrait {
        PageTrait::__wakeup as private PageTraitWakeup;
        WidgetContainerTrait::__wakeup as private WidgetContainerTraitWakeup;
    }

    /**
     * {@inheritdoc}
     */
    public function escape($unquoted)
    {
        return \htmlentities($unquoted, null, 'UTF-8');
    }

    /**
     * {@inheritdoc}
     */
    public function __toString()
    {
        $r = '<!DOCTYPE html>';
        $r .= '<html>';

        $r .= '<head>';
        $r .= '<title>' . $this->escape($this->getTitle()) . '</title>';
        $r .= '<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />';
        $r .= '<meta name="viewport" content="width=device-width, initial-scale=1.0" />';

        foreach ($this->getScripts() AS $script) {
            $r .= $script;
        }

        foreach ($this->getStyleSheets() AS $style) {
            $r .= $style;
        }

        $r .= '</head>';

        $r .= '<body id="' . $this->escape($this->id) . '">';

        foreach ($this->children() AS $child) {
            $r .= $child;
        }

        $r .= '</body>';
        $r .= '</html>';

        return $r;
    }

    public function __wakeup()
    {
        $this->WidgetContainerTraitWakeup();
        $this->PageTraitWakeup();
    }
}
