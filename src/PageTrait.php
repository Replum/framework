<?php

/*
 * This file is part of Replum: the web widget framework.
 *
 * Copyright (c) Dennis Birkholz <dennis@birkholz.org>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Replum;

trait PageTrait
{
    /**
     * @var array<\Replum\StyleSheetInterface>
     */
    private $PageTraitStyles = [];

    /**
     * @see \Replum\PageInterface::addStyleSheet()
     */
    public function addStyleSheet(\Replum\StyleSheetInterface $style)
    {
        $this->PageTraitStyles[] = $style;
        return $this;
    }

    /**
     * @see \Replum\PageInterface::getStyleSheets()
     */
    public function getStyleSheets()
    {
        return $this->PageTraitStyles;
    }

    /**
     * @var array<\Replum\ScriptInterface>
     */
    private $PageTraitScripts = [];

    /**
     * @see \Replum\PageInterface::addScript()
     */
    public function addScript(\Replum\ScriptInterface $script)
    {
        $this->PageTraitScripts[] = $script;
        return $this;
    }

    /**
     * @see \Replum\PageInterface::getScripts()
     */
    public function getScripts()
    {
        return $this->PageTraitScripts;
    }

    /**
     * @var \Replum\ParameterRegistry
     */
    private $PageTraitParameterRegistry;

    /**
     * Silently initializes the parameter registry with the provided default implementation on first access
     * @see \Replum\PageInterface::getParameterRegistry()
     */
    public function getParameterRegistry()
    {
        if (is_null($this->PageTraitParameterRegistry)) {
            $this->initParameterRegistry();
        }

        return $this->PageTraitParameterRegistry;
    }

    /**
     * @see \Replum\PageInterface::initParameterRegistry()
     */
    public function initParameterRegistry(\Replum\ParameterRegistry $newParameterRegistry = null)
    {
        if (!is_null($this->PageTraitParameterRegistry)) {
            throw new \RuntimeException("Can not replace existing parameter registry!");
        }

        if (is_null($newParameterRegistry)) {
            $this->PageTraitParameterRegistry = new \Replum\ParameterRegistry();
        } else {
            $this->PageTraitParameterRegistry = $newParameterRegistry;
        }

        return $this;
    }

    public function __wakeup()
    {
    }

    public $remoteActions = [];

    public function executeRemote($action, $parameters = [])
    {
        $this->remoteActions[] = [$action, $parameters];
    }

    ######################################################################
    # Widget ID registration
    ######################################################################

    /**
     * A list of all IDs that are used by widgets.
     * Stored to prevent ID clashes for new widgets.
     *
     * @var array<string>
     */
    protected $takenWidgetIdList = [];

    /**
     * Generate a new ID for a widget
     *
     * @param integer $length
     * @return string
     */
    public function generateID($length = 5)
    {
        do {
            $newID = 'w_' . \str_replace(['/', '+'], ['_', '-'], \substr(\base64_encode(random_bytes($length)), 0, $length));
            $length++;
        } while (\in_array($newID, $this->takenWidgetIdList));
        
        $this->takenWidgetIdList[] = $newID;
        return $newID;
    }

    /**
     * Register the supplied ID.
     * Returns whether the ID was free and is registered now or not.
     *
     * @param string $newID
     * @return boolean
     */
    public function registerID($newID)
    {
        if (!\in_array($newID, $this->takenWidgetIdList)) {
            $this->takenWidgetIdList[] = $newID;
            return true;
        } else {
            return false;
        }
    }
}
