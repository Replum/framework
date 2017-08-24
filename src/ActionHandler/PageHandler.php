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
        $pageClass = \str_replace('/', '\\', $context->getPageName());

        // Get the name and class of the current page
        foreach ($context->getPageNamespaces() as $pageNamespace) {
            $tryclass = $pageNamespace . '\\' . $pageClass;

            if (\class_exists($tryclass) && \is_a($tryclass, PageInterface::class, true)) {
                $class = $tryclass;
                break;
            }
        }

        if (empty($class)) {
            return new Response('404: page "' . $context->getPageName() . '" not found!', 404);
        }

        /* @var $page \Replum\PageInterface */
        $page = new $class($context);
        $response = new Response($page->render());

        //\apcu_store($this->executer->getCacheNamespace() . '.' . $page->id, $page, 0);
        \apcu_store($this->executer->getCacheNamespace() . '.' . $page->getWidgetId(), \gzdeflate(\serialize($page)), 0);

        return $response;
    }


    protected function generatePageID()
    {
        $length = 8;

        do {
            $r = Util::randomString($length);
            $length++;
        } while (\apcu_exists($this->executer->getCacheNamespace() . '.' . $r));

        return $r;
    }
}
