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
interface PageInterface extends WidgetContainerInterface
{
    /**
     * Get the parameter registry that holds all callbacks to fill widget properties from request variables
     * @return \Replum\ParameterRegistry
     */
    function getParameterRegistry();

    /**
     * Initialize the parameter registry with the supplied parameter registry object or create a new object
     * @param \Replum\ParameterRegistry $newParameterRegistry
     * @return \Replum\PageInterface $this for chaining
     */
    function initParameterRegistry(\Replum\ParameterRegistry $newParameterRegistry = null);

    /**
     * Get the document title
     * @return string
     */
    function getTitle();

    /**
     * Set the document title
     * @param string $newTitle
     * @return \Replum\PageInterface $this for chaining
     */
    function setTitle($newTitle);

    /**
     * Escape the supplied string according to the current HTML escaping rules
     *
     * @param string The raw string
     * @return string
     */
    function escape($unquoted);

    /**
     * Execute the supplied action on the remote side (in the browser).
     *
     * @param string $action
     * @param array $parameters
     */
    function executeRemote($action, $parameters = []);
}
