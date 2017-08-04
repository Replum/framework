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

use \Composer\Autoload\ClassLoader;
use \Symfony\Component\HttpFoundation\Request;

/**
 * A Framework context holds all relevant configuration and runtime information of the Framework.
 * It is provided to all event handlers.
 * 
 * Extend the default framework Context class to add additional information to the context.
 *
 * @author Dennis Birkholz <dennis@birkholz.org>
 */
interface ContextInterface
{
    /**
     * Get the currently used Composer autoloader
     */
    function getAutoloader() : ClassLoader;
    
    /**
     * Get the domain name used to access this framework installation
     */
    function getDomain() : string;
    
    /**
     * Get the document root of the framework installation.
     * Can be below the apache configured document root if the framework is installed in a subfolder
     */
    function getDocumentRoot() : string;
    
    /**
     * Get a Request object representing the current request
     */
    function getRequest() : Request;
    
    /**
     * Whether SSL is used or not
     */
    function hasTls() : bool;
    
    /**
     * Get the URL prefix requires to make an URL absolute on this server.
     */
    function getUrlPrefix() : string;
    
    /**
     * Get the base directory that contains the Composer installed dependencies.
     */
    function getVendorDir() : string;
}