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

abstract class Page extends \Replum\Page
{
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

        foreach ($this->getStyleSheets() AS $style) {
            $r .= $style;
        }

        $r .= '</head>';

        $r .= '<body ' . $this->renderAttributes() . '>';

        foreach ($this->children() AS $child) {
            $r .= $child;
        }

        foreach ($this->getScripts() AS $script) {
            $r .= $script;
        }

        $r .= '</body>';
        $r .= '</html>';

        return $r;
    }

    ######################################################################
    # StyleSheet management                                              #
    ######################################################################

    /**
     * @var array<StyleSheetInterface>
     */
    private $stylesheets = [];

    /**
     */
    public function addStyleSheet(StyleSheetInterface $style)
    {
        $this->stylesheets[] = $style;
        return $this;
    }

    /**
     */
    public function getStyleSheets()
    {
        return $this->stylesheets;
    }

    ######################################################################
    # JavaScript management                                              #
    ######################################################################

    /**
     * @var array<ScriptInterface>
     */
    private $javascripts = [];

    /**
     */
    public function addScript(ScriptInterface $script)
    {
        $this->javascripts[] = $script;
        return $this;
    }

    /**
     */
    public function getScripts()
    {
        return $this->javascripts;
    }
}
