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

abstract class Page implements PageInterface
{
    /**
     * Default constructor
     */
    public function __construct(ContextInterface $context, string $pageId = null)
    {
        $this->context = $context;
        $this->pageId = ($pageId ? $pageId : Util::randomString());
    }

    /**
     * Empty default method so a parent::__wakeup() call will work
     */
    public function __wakeup()
    {
    }

    ######################################################################
    # Page ID                                                            #
    ######################################################################

    /**
     * @var string
     */
    private $pageId;

        /**
     * Get the unique ID of this page
     */
    final public function getPageID() : string
    {
        return $this->pageId;
    }

    ######################################################################
    # Parameter registry                                                 #
    ######################################################################

    /**
     * @var \Replum\ParameterRegistry
     */
    private $PageTraitParameterRegistry;

    /**
     * Silently initializes the parameter registry with the provided default implementation on first access
     * @see \Replum\PageInterface::getParameterRegistry()
     */
    public function getParameterRegistry() : ParameterRegistry
    {
        if (is_null($this->PageTraitParameterRegistry)) {
            $this->initParameterRegistry();
        }

        return $this->PageTraitParameterRegistry;
    }

    /**
     * @see \Replum\PageInterface::initParameterRegistry()
     */
    public function initParameterRegistry(ParameterRegistry $newParameterRegistry = null) : PageInterface
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
            $newID = 'w_' . Util::randomString($length);
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

    ######################################################################
    # Context handling                                                   #
    ######################################################################

    private $context;

    /**
     * @see \Replum\PageInterface::getContext()
     */
    public function getContext() : ContextInterface
    {
        return $this->context;
    }

    /**
     * @see \Replum\PageInterface::setContext()
     */
    public function setContext(ContextInterface $context) : PageInterface
    {
        $this->context = $context;
        return $this;
    }

    ######################################################################
    # Widget management                                                  #
    ######################################################################

    /**
     * @var WidgetInterface[]
     */
    private $widgetByIdMapping = [];

    /**
     * @see PageInterface::registerWidget()
     */
    final public function registerWidget(WidgetInterface $widget) : string
    {
        $length = 5;
        do {
            $id = Util::randomString($length++);
        } while (isset($this->widgetByIdMapping[$id]));

        $this->widgetByIdMapping[$id] = $widget;
        return $id;
    }

    /**
     * @see PageInterface::changeWidgetId()
     */
    final public function changeWidgetId(WidgetInterface $widget, string $oldId, string $newId)
    {
        if (isset($this->widgetByIdMapping[$newId]) && $this->widgetByIdMapping[$newId] !== $widget) {
            throw new \InvalidArgumentException('Can not reassign taken ID "' . $newId . '"!');
        }

        unset($this->widgetByIdMapping[$oldId]);
        $this->widgetByIdMapping[$newId] = $widget;
    }

    /**
     * @see PageInterface::getWidgetById()
     */
    final public function getWidgetById(string $id) : WidgetInterface
    {
        if (!isset($this->widgetByIdMapping[$id]) || !($this->widgetByIdMapping[$id] instanceof WidgetInterface)) {
            throw new \InvalidArgumentException('Unknown widget with ID "' . $id . '"!');
        }

        return $this->widgetByIdMapping[$id];
    }
}
