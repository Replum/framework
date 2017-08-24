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
use \Replum\Events\WidgetChangeEvent;
use \Replum\Events\WidgetOnChangeEvent;
use \Replum\Events\WidgetOnClickEvent;
use \Replum\Events\WidgetOnDoubleClickEvent;
use \Replum\Events\WidgetOnSubmitEvent;
use \Replum\Html\WidgetInterface as HtmlWidgetInterface;
use \Symfony\Component\HttpFoundation\JsonResponse;

/**
 * @author Dennis Birkholz <dennis@birkholz.org>
 */
class JsonHandler
{
    const EVENT_PARAMETER_NAME = 'replum_event';
    const PAGE_ID_PARAMETER_NAME = 'replum_pid';
    const SOURCE_PARAMETER_NAME = 'replum_source';
    const VALUE_PARAMETER_NAME = 'replum_value';
    const CHECKED_PARAMETER_NAME = 'replum_checked';
    const ACTION_PARAMETER_NAME = 'replum_action';
    const PARAMS_PARAMETER_NAME = 'replum_params';
    const TARGET_PARAMETER_NAME = 'replum_target';
    const DATA_PARAMETER_NAME = 'replum_data';

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
        try {
            /* $var $request \Symfony\Component\HttpFoundation\Request */
            $request = $this->executer->getContext()->getRequest();
            $event = $request->request->get(self::EVENT_PARAMETER_NAME);
            $page_id = $request->request->get(self::PAGE_ID_PARAMETER_NAME);

            /* @var $page \Replum\PageInterface */
            //$page = \apcu_fetch($this->executer->getCacheNamespace() . '.' . $page_id);
            $page = \unserialize(\gzinflate(\apcu_fetch($this->executer->getCacheNamespace() . '.' . $page_id)));

            if (!($page instanceof \Replum\PageInterface)) {
                throw new \RuntimeException('Can not restore page!');
            }

            $page->setContext($this->executer->getContext());

            // Handler to monitor changes
            $changedWidgets = new \SplObjectStorage();
            $changeHandler = function(WidgetChangeEvent $event) use ($changedWidgets) {
                $changedWidgets->attach($event->widget);
            };
            $page->on(WidgetChangeEvent::class, $changeHandler);

            $widget = $page->getWidgetById($request->request->get(self::SOURCE_PARAMETER_NAME));
            if ($request->request->get(self::VALUE_PARAMETER_NAME) !== null) {
                $widget->setValue($request->request->get(self::VALUE_PARAMETER_NAME));
            } elseif ($request->request->get(self::CHECKED_PARAMETER_NAME) !== null) {
                $widget->setChecked($request->request->get(self::CHECKED_PARAMETER_NAME));
            }

            switch ($event) {
                case WidgetOnClickEvent::NAME:
                    $widget->dispatch(new WidgetOnClickEvent($widget));
                    break;

                case WidgetOnChangeEvent::NAME:
                    $widget->dispatch(new WidgetOnChangeEvent($widget));
                    break;

                case WidgetOnDoubleClickEvent::NAME:
                    $widget->dispatch(new WidgetOnDoubleClickEvent($widget));
                    break;

                case WidgetOnSubmitEvent::NAME:
                    $widget->dispatch(new WidgetOnSubmitEvent($widget));
                    break;

                default:
                    throw new \InvalidArgumentException('Invalid event "' . $event . '"!');
            }

            $page->off(WidgetChangeEvent::class, $changeHandler);
            $data = $this->handleChangedWidgets($page, $changedWidgets);

            //\apcu_store($this->executer->getCacheNamespace() . '.' . $page->getPageID(), $page, 0);
            \apcu_store($this->executer->getCacheNamespace() . '.' . $page->getWidgetId(), \gzdeflate(\serialize($page)), 0);

            $response = new JsonResponse($data);
        } catch (\Throwable $e) {
            $data = [[
                self::ACTION_PARAMETER_NAME => 'error',
                self::PARAMS_PARAMETER_NAME => [$this->dumpException($e)],
            ]];

            $response = new JsonResponse($data, 500);
        }

        $response->send();
        exit;
    }

    protected function handleChangedWidgets(PageInterface $page, \SplObjectStorage $widgets)
    {
        $data = [];
        $updatedWidgets = new \SplObjectStorage();

        foreach ($widgets as $widget) {
            while (!($widget instanceof HtmlWidgetInterface) || !$widget->hasID()) {
                if (!$widget->hasParent()) {
                    throw new \RuntimeException('Can not update detached widget without updatable parent!');
                }

                $widget = $widget->getParent();
            }

            // Render each widget only once
            if (isset($updatedWidgets[$widget])) {
                continue;
            }

            $updatedWidgets[$widget] = true;
            $data[] = [
                self::ACTION_PARAMETER_NAME => 'replace',
                self::TARGET_PARAMETER_NAME => $widget->getID(),
                self::DATA_PARAMETER_NAME => $widget->render(),
            ];
        }

        foreach ($page->remoteActions as list($action, $parameters)) {
            $data[] = [
                self::ACTION_PARAMETER_NAME => $action,
                self::PARAMS_PARAMETER_NAME => $parameters,
            ];
        }

        $page->remoteActions = [];

        return $data;
    }

    private function dumpException(\Throwable $e)
    {
        $r = 'Exception "' . \get_class($e) . '" with message "' . $e->getMessage() . '" in ' . $e->getFile() . ':' . $e->getLine() . PHP_EOL . PHP_EOL;

        $trace = $e->getTrace();
        if ($e instanceof \ErrorException) { \array_shift($trace); }

        foreach ($trace as $i => $traceline) {
            $r .= '#' . $i . ( isset($traceline['file']) ? ' ' . $traceline['file'] . '(' . $traceline['line'] . ')' : '' ) . ':' . PHP_EOL;

            if (isset($traceline['function'])) {
                $r .= '    ';
                if (isset($traceline['class'])) {
                    $r .= $traceline['class'] . ($traceline['type'] ? : '');
                }
                $r .= $traceline['function'];
                $r .= '(';

                foreach ($traceline['args'] as $argNum => $arg) {
                    if ($argNum) { $r .= ','; }
                    $r .= PHP_EOL . '        ';

                    if (\is_object($arg)) {
                        $r .= \get_class($arg);
                    } elseif (\is_array($arg)) {
                        $r .= 'Array(';

                        $first = true;
                        foreach ($arg as $arrayKey => $arrayValue) {
                            if ($first) {
                                $first = false;
                            } else {
                                $r .= ',';
                            }

                            $r .= PHP_EOL . '            ';
                            $r .= $arrayKey . ' => ';

                            if (\is_object($arrayValue)) {
                                $r .= \get_class($arrayValue);
                            } elseif (\is_array($arrayValue)) {
                                $r .= 'Array(' . \count($arrayValue) . ')';
                            } else {
                                $r .= \gettype($arrayValue) . ' "' . $arrayValue . '"';
                            }
                        }
                        if (!$first) { $r .= PHP_EOL . '        '; }
                        $r .= ')';
                    } else {
                        $r .= \gettype($arg) . ' "' . $arg . '"';
                    }
                }

                if (\count($traceline['args'])) { $r .= PHP_EOL . '    '; }
                $r .= ')' . PHP_EOL . PHP_EOL;
            }
        }

        return $r;
    }
}
