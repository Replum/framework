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

use \nexxes\dependency\Gateway as dep;
use \nexxes\common\RelativePath;

/**
 * The Executer creates or restores the current page and the associated widget registry
 */
class Executer
{
    /**
     * @var \Symfony\Component\HttpFoundation\Request
     */
    private $request = null;

    /**
     * Get the request object of the current request
     *
     * @return \Symfony\Component\HttpFoundation\Request
     */
    public function getRequest()
    {
        return $this->request;
    }


    /**
     * @var \Symfony\Component\HttpFoundation\Session\Session
     */
    private $session = null;

    /**
     * Get the currently active session
     *
     * @return \Symfony\Component\HttpFoundation\Session\Session
     */
    public function getSession()
    {
        return $this->session;
    }


    /**
     * The namespace each page class must exist in
     * @var string
     */
    private $pageNamespace;

    public function getPageNamespace()
    {
        return $this->pageNamespace;
    }


    private $cacheNamespace = 'replum.pages';

    public function getCacheNamespace()
    {
        return $this->cacheNamespace;
    }


    /**
     * @var array<callable>
     */
    private $ActionHandler = [];

    public function registerAction($actionName, callable $handler)
    {
        $this->ActionHandler[$actionName] = $handler;
        return $this;
    }


    public function __construct($pageNamespace)
    {
        $this->pageNamespace = $pageNamespace;

        // Handle request and session
        $this->request = \Symfony\Component\HttpFoundation\Request::createFromGlobals();

        if ($this->request->hasPreviousSession() || $this->request->hasSession()) {
            $this->session = $this->request->getSession();
        } else {
            $this->session = new \Symfony\Component\HttpFoundation\Session\Session();
            $this->request->setSession($this->session);
        }

        if (!$this->session->isStarted()) {
            $this->session->start();
        }

        // Security measure: regenerate session id to avoid session fixation
        //$this->session->migrate();

        $this->registerAction('page', function(Executer $exec) { return [new \Replum\ActionHandler\PageHandler($exec), 'execute']; });
        $this->registerAction('json', function(Executer $exec) { return [new \Replum\ActionHandler\JsonHandler($exec), 'execute']; });
        $this->registerAction('vendor', function(Executer $exec) { return [new \Replum\ActionHandler\VendorHandler($exec), 'execute']; });
    }

    
    public function execute()
    {
        $action = $this->request->query->get('nexxes_action', 'page');
        if (($action == 'page') && $this->request->isXmlHttpRequest()) {
            $action = 'json';
        }

        if (!isset($this->ActionHandler[$action])) {
            throw new \InvalidArgumentException('Unknown action type: ' . $action);
        }

        $handler = $this->ActionHandler[$action]($this);

        try {
            /* @var $response \Symfony\Component\HttpFoundation\Response */
            $response = $handler();
            $response->send();
        } catch (\Exception $e) {
            echo '<pre>' . $e . '</pre>';
            exit;
        }
    }
}
