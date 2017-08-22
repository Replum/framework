<?php

/*
 * This file is part of Replum: the web widget framework.
 *
 * Copyright (c) Dennis Birkholz <dennis@birkholz.org>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Replum\ActionHandler;

use \Replum\PageInterface;
use \Replum\Util;
use \Symfony\Component\HttpFoundation\Response;

/**
 * @author Dennis Birkholz <dennis@birkholz.org>
 */
class PageHandler
{
    /**
     * @var \Replum\Executer
     */
    private $executer;

    public function __construct(\Replum\Executer $executer)
    {
        $this->executer = $executer;
    }

    public function execute()
    {
        $context = $this->executer->getContext();

        $path = \rawurldecode($context->getRequest()->getPathInfo());
        // Access to root index document
        if ($path === '/' || $path === '') {
            $pagename = 'Index';
        }

        else {
            // Strip trailing /
            $pagename = \substr($path, 1);

            // Access to namespace index document
            if ($pagename[\strlen($pagename)-1] === '/') {
                $pagename .= 'Index';
            }

            $pagename = \str_replace('/', '\\', $pagename);
        }

        // Get the name and class of the current page
        foreach ($context->getPageNamespaces() as $pageNamespace) {
            $tryclass = $pageNamespace . '\\' . $pagename;

            if (\class_exists($tryclass) && \is_a($tryclass, PageInterface::class, true)) {
                $class = $tryclass;
                break;
            }
        }

        if (empty($class)) {
            throw new \InvalidArgumentException('Invalid page "' . $path . '"!');
        }

        /* @var $page \Replum\PageInterface */
        $page = new $class($context);
        $response = new Response($page->render());

        //\apc_store($this->executer->getCacheNamespace() . '.' . $page->id, $page, 0);
        \apc_store($this->executer->getCacheNamespace() . '.' . $page->getPageID(), \gzdeflate(\serialize($page)), 0);

        return $response;
    }


    protected function generatePageID()
    {
        $length = 8;

        do {
            $r = Util::randomString($length);
            $length++;
        } while (\apc_exists($this->executer->getCacheNamespace() . '.' . $r));

        return $r;
    }
}
