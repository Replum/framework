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
 * @author Dennis Birkholz <dennis@birkholz.org>
 */
class Context implements ContextInterface
{
    /**
     * @var ClassLoader
     */
    private $autoloader;

    /**
     * @var string
     */
    private $documentRoot;

    /**
     * @var string
     */
    private $domain;

    /**
     * @var string
     */
    private $pagename;

    /**
     * @var Request
     */
    private $request;

    /**
     * @var bool
     */
    private $tls;

    /**
     * @var string
     */
    private $urlPrefix;

    /**
     * @var string
     */
    private $vendorDir;

    /**
     * @var bool
     */
    private $rewriteEnabled;

    /**
     * @var bool
     */
    private $production = false;


    public function __construct(ClassLoader $autoloader = null)
    {
        $this->initialize();
    }

    /**
     * Nothing is serialized, re-initialize on restore
     */
    public function __sleep()
    {
        return [];
    }

    /**
     * Re-initialize after serializiation
     */
    public function __wakeup()
    {
        $this->initialize();
    }

    final private function initialize(ClassLoader $autoloader = null)
    {
        if ($autoloader !== null) {
            $this->autoloader = $autoloader;
        } else {
            $this->autoloader = $this->findAutoloader();
        }

        $this->request = Request::createFromGlobals();
        $this->documentRoot = \dirname($_SERVER['SCRIPT_FILENAME']);
        $this->domain = $this->request->getHost();
        $this->tls = $this->request->isSecure();
        $this->vendorDir = \dirname(\dirname((new \ReflectionClass($this->autoloader))->getFileName()));

        // URL starts with script name, so pathinfo is used as a prefix
        if (\substr($this->request->getRequestUri(), 0, \strlen($this->request->getScriptName())) === $this->request->getScriptName()) {
            $this->rewriteEnabled = false;
            $this->urlPrefix = $this->request->getScriptName();
        }

        // URL uses rewriting, living inside basepath
        elseif (\substr($this->request->getRequestUri(), 0, \strlen($this->request->getBasePath())) === $this->request->getBasePath()) {
            $this->rewriteEnabled = true;
            $this->urlPrefix = $this->request->getBasePath();
        }

        else {
            throw new \RuntimeException('Can not determine base url and rewrite status from current server config!');
        }

        $this->pagename = $this->findPageName($this->request);
    }

    final private function findAutoloader() : ClassLoader
    {
        if (!$loaders = \spl_autoload_functions()) {
            throw new \RuntimeException("No autoloader registered! Replum is designed to be installed by Composer and depends havily on class autoloading. Please use Composer's autoloader.");
        }

        foreach ($loaders as $loader) {
            if (\is_array($loader) && isset($loader[0]) && ($loader[0] instanceof ClassLoader)) {
                return $loader[0];
            }
        }

        throw new \RuntimeException("Composer's autoloader not found! Replum is designed to be installed by Composer and depends havily on class autoloading. Please use Composer's autoloader.");
    }

    final private function findPageName(Request $request) : string
    {
        $path = \rawurldecode($request->getPathInfo());

        // Access to root index document
        if ($path === '/' || $path === '') {
            return 'Index';
        }

        // Strip trailing /
        $pagename = \substr($path, 1);

        // Access to namespace index document
        if ($pagename[\strlen($pagename)-1] === '/') {
            $pagename .= 'Index';
        }

        return $pagename;
    }

    /**
     * @see ContextInterface::getAutoloader()
     */
    public function getAutoloader() : ClassLoader
    {
        return $this->autoloader;
    }

    /**
     * @see ContextInterface::getDocumentRoot()
     */
    public function getDocumentRoot(): string
    {
        return $this->documentRoot;
    }

    /**
     * @see ContextInterface::getDomain()
     */
    public function getDomain(): string
    {
        return $this->domain;
    }

    /**
     * @see ContextInterface::getPageName()()
     */
    public function getPageName(): string
    {
        return $this->pagename;
    }

    /**
     * @see ContextInterface::getRequest()
     */
    public function getRequest(): Request
    {
        return $this->request;
    }

    /**
     * @see ContextInterface::hasTls()
     */
    public function hasTls(): bool
    {
        return $this->tls;
    }

    /**
     * @see ContextInterface::getUrlPrefix()
     */
    public function getUrlPrefix(): string
    {
        return $this->urlPrefix;
    }

    /**
     * @see ContextInterface::getVendorDir()
     */
    public function getVendorDir(): string
    {
        return $this->vendorDir;
    }

    ######################################################################
    # Namespace handling                                                 #
    ######################################################################

    private $pageNamespaces = [];

    /**
     * @see ContextInterface::appendPageNamespace()
     */
    public function appendPageNamespace(string $namespace)
    {
        $this->pageNamespaces[] = $namespace;
    }

    /**
     * @see ContextInterface::getPageNamespaces()
     */
    public function getPageNamespaces(): array
    {
        return $this->pageNamespaces;
    }

    /**
     * @see ContextInterface::prependPageNamespace()
     */
    public function prependPageNamespace(string $namespace)
    {
        \array_unshift($this->pageNamespaces, $namespace);
    }

    ######################################################################
    # Production mode                                                    #
    ######################################################################

    /**
     * @see ContextInterface::isProduction()
     */
    public function isProduction() : bool
    {
        return $this->production;
    }

    public function setProduction(bool $production = true) : ContextInterface
    {
        $this->production = $production;
        return $this;
    }
}
