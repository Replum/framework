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
    public function __construct(\Replum\ContextInterface $context, string $pageId = null)
    {
        parent::__construct($context, $pageId);

        $this->body = (new Body($this))->needID();
    }

    /**
     * @var Body
     */
    private $body;

    final public function getBody() : Body
    {
        return $this->body;
    }

    /**
     * {@inheritdoc}
     */
    public function render() : string
    {
        $r = '<!DOCTYPE html>';
        $r .= '<html id="' . $this->getPageID() . '">';

        $r .= '<head>';
//        $r .= '<title>' . \Replum\Util::escapeHtml($this->getTitle()) . '</title>';
        $r .= '<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />';
        $r .= '<meta name="viewport" content="width=device-width, initial-scale=1.0" />';

        foreach ($this->getStyleSheets() AS $style) {
            $r .= $style;
        }

        $r .= '</head>';

        $r .= $this->body->render();

        foreach ($this->getScripts() AS $script) {
            $r .= $script;
        }

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
