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

use \Replum\ActionHandler\JsonHandler;
use \Replum\ActionHandler\PageHandler;
use \Replum\ActionHandler\VendorHandler;

/**
 * The Executer creates or restores the current page and the associated widget registry
 */
class Executer
{
    /**
     * @var ContextInterface
     */
    private $context;
    
    /**
     * Get the current pae context
     */
    public function getContext() : ContextInterface
    {
        return $this->context;
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


    public function __construct(ContextInterface $context = null)
    {
        $this->context = ($context !== null ? $context : new Context());

        if ($this->getContext()->getRequest()->hasPreviousSession() || $this->getContext()->getRequest()->hasSession()) {
            $this->session = $this->getContext()->getRequest()->getSession();
        } else {
            $this->session = new \Symfony\Component\HttpFoundation\Session\Session();
            $this->getContext()->getRequest()->setSession($this->session);
        }

        if (!$this->session->isStarted()) {
            $this->session->start();
        }

        // Security measure: regenerate session id to avoid session fixation
        //$this->session->migrate();

        $this->registerAction('page', function(Executer $exec) { return [new PageHandler($exec), 'execute']; });
        $this->registerAction('json', function(Executer $exec) { return [new JsonHandler($exec), 'execute']; });
        $this->registerAction('vendor', function(Executer $exec) { return [new VendorHandler($exec), 'execute']; });
    }

    
    public function execute()
    {
        $action = $this->getContext()->getRequest()->query->get(JsonHandler::ACTION_PARAMETER_NAME, 'page');
        if (($action === 'page') && $this->getContext()->getRequest()->isXmlHttpRequest()) {
            $action = 'json';
        }
        
        elseif (($action === 'page') && ('/vendor/' === \substr($this->getContext()->getRequest()->getPathInfo(), 0, 8))) {
            $action = 'vendor';
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
            header($_SERVER['SERVER_PROTOCOL'] .' 500 Internal server error', true, 500);
            echo '<pre>' . $e . '</pre>';
            exit;
        }
    }
}
