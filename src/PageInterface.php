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

/**
 * A page represents the main entity to visualize
 */
interface PageInterface extends WidgetInterface, WidgetContainerInterface
{
    /**
     * Constructor requires the context as parameter
     */
    function __construct(ContextInterface $context, string $pageId = null);

    ######################################################################
    # Context handling                                                   #
    ######################################################################

    /**
     * Get the current page Context.
     * The Context holds runtime configuration, execution context (like current URL) and services.
     */
    function getContext() : ContextInterface;

    /**
     * Replace the current context of the page with another one.
     *
     * @internal Used after unserialization of the page
     * @return $this
     */
    function setContext(ContextInterface $context) : self;

    ######################################################################
    # Parameter registry                                                 #
    ######################################################################

    /**
     * Get the parameter registry that holds all callbacks to fill widget properties from request variables
     */
    function getParameterRegistry() : ParameterRegistry;

    /**
     * Initialize the parameter registry with the supplied parameter registry object or create a new object
     *
     * @return $this
     */
    function initParameterRegistry(\Replum\ParameterRegistry $newParameterRegistry = null) : self;

    /**
     * Get the document title
     * @return string
     */
    //function getTitle();

    /**
     * Set the document title
     * @param string $newTitle
     * @return \Replum\PageInterface $this for chaining
     */
    //function setTitle($newTitle);

    /**
     * Execute the supplied action on the remote side (in the browser).
     *
     * @param string $action
     * @param array $parameters
     */
    function executeRemote($action, $parameters = []);
}
