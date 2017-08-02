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

use \nexxes\dependency\Gateway as dep;
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
        $path = \rawurldecode($this->executer->getRequest()->getPathInfo());
        // Access to root index document
        if ($path == '/') {
            $pagename = 'Index';
        } else {
            // Strip trailing /
            $pagename = \substr($path, 1);

            // Access to namespace index document
            if ($pagename[\strlen($pagename)-1] === '/') {
                $pagename .= 'Index';
            }
        }

        $pagename = \str_replace('/', '\\', $pagename);

        // Get the name and class of the current page
        $class = $this->executer->getPageNamespace() . '\\' . $pagename;

        if (!\class_exists($class)) {
            // Try to append Index to
            $class .= '\\' . 'Index';

            if (!\class_exists($class)) {
                phpinfo();
                throw new \InvalidArgumentException('Invalid page "' . $path . '"!');
            }
        }

        /* @var $page \Replum\PageInterface */
        $page = new $class();
        $page->id = $this->generatePageID();
        dep::registerObject(\Replum\PageInterface::class, $page);

        $response = new Response((string)$page);

        //\apc_store($this->executer->getCacheNamespace() . '.' . $page->id, $page, 0);
        \apc_store($this->executer->getCacheNamespace() . '.' . $page->id, \gzdeflate(\serialize($page)), 0);

        return $response;
    }

    
    protected function generatePageID()
    {
        $length = 8;

        do {
            $r = \str_replace(['/', '+'], ['_', '-'], \substr(\base64_encode(random_bytes($length)), 0, $length));
            $length++;
        } while (\apc_exists($this->executer->getCacheNamespace() . '.' . $r));

        return $r;
    }
}
