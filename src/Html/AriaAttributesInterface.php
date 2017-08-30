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

/**
 * ARIA (Accessible Rich Internet Applications) attributes
 *
 * @link https://www.w3.org/TR/html5/dom.html#wai-aria
 * @author Dennis Birkholz <dennis@birkholz.org>
 */
interface AriaAttributesInterface extends \Replum\WidgetInterface
{
    ######################################################################
    # Common attributes                                                  #
    ######################################################################

    /**
     * Get the aria-$name attribute
     */
    function getAria(string $name) : string;

    /**
     * Check whether the aria-$name attribute is set
     */
    function hasAria(string $name) : bool;

    /**
     * @return static $this
     */
    function setAria(string $name, string $value = null) : self;

    ######################################################################
    # Role attribute                                                     #
    ######################################################################

    /**
     * Get the ARIA role of the element if defined.
     *
     * @link http://www.w3.org/TR/html5/dom.html#aria-role-attribute
     * @link http://www.w3.org/TR/wai-aria/roles
     */
    function getRole() : string;

    /**
     * Whether the aria role is set.
     *
     * @link http://www.w3.org/TR/html5/dom.html#aria-role-attribute
     * @link http://www.w3.org/TR/wai-aria/roles
     */
    function hasRole() : bool;

    /**
     * Set the ARIA role of the element.
     *
     * @return static $this
     * @link http://www.w3.org/TR/html5/dom.html#aria-role-attribute
     * @link http://www.w3.org/TR/wai-aria/roles
     */
    function setRole(string $newRole = null) : self;
}
