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

use \Replum\Event;
use \Replum\Events\WidgetOnChangeEvent;
use \Replum\Events\WidgetOnClickEvent;
use \Replum\Events\WidgetOnDoubleClickEvent;
use \Replum\Events\WidgetOnSubmitEvent;

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

            if (!\in_array($event, ['click', 'change', 'dblclick', 'submit',])) {
                throw new \InvalidArgumentException('Invalid event with name "' . $event . '"');
            }

            $page_id = $request->request->get(self::PAGE_ID_PARAMETER_NAME);

            /* @var $page \Replum\PageInterface */
            //$page = \apc_fetch($this->executer->getCacheNamespace() . '.' . $page_id);
            $page = \unserialize(\gzinflate(\apc_fetch($this->executer->getCacheNamespace() . '.' . $page_id)));

            if (!($page instanceof \Replum\PageInterface)) {
                throw new \RuntimeException('Can not restore page!');
            }

            $page->setContext($this->executer->getContext());

            $widget = $page->getBody()->findById($request->request->get(self::SOURCE_PARAMETER_NAME));
            if ($request->request->get(self::VALUE_PARAMETER_NAME) !== null) {
                $widget->setValue($request->request->get(self::VALUE_PARAMETER_NAME));
            } elseif ($request->request->get(self::CHECKED_PARAMETER_NAME) !== null) {
                $widget->setChecked($request->request->get(self::CHECKED_PARAMETER_NAME));
            }


            if ($event == 'click') {
                $widget->dispatch(new WidgetOnClickEvent($widget));
            } elseif ($event == 'change') {
                $widget->dispatch(new WidgetOnChangeEvent($widget));
            } elseif ($event == 'dblclick') {
                $widget->dispatch(new WidgetOnDoubleClickEvent($widget));
            } elseif ($event == 'submit') {
                $widget->dispatch(new WidgetOnSubmitEvent($widget));
            }

            $data = $this->handleChangedWidgets($page);

            //\apc_store($this->executer->getCacheNamespace() . '.' . $page->getPageID(), $page, 0);
            \apc_store($this->executer->getCacheNamespace() . '.' . $page->getPageID(), \gzdeflate(\serialize($page)), 0);
        } catch (\Exception $e) {
            $data = [[
                self::ACTION_PARAMETER_NAME => 'error',
                self::PARAMS_PARAMETER_NAME => [$this->dumpException($e)],
            ]];
        }

        header('Content-Type: text/json');
        echo json_encode($data);

        exit;
    }

    protected function handleChangedWidgets(\Replum\PageInterface $page)
    {
        $data = [];

        foreach ($page->getDescendants() as $widget) {
            /* @var $widget \Replum\WidgetInterface */
            if ($widget->isChanged() && $widget->hasID()) {
                $data[] = [
                    self::ACTION_PARAMETER_NAME => 'replace',
                    self::TARGET_PARAMETER_NAME => $widget->getID(),
                    self::DATA_PARAMETER_NAME => (string) $widget,
                ];
            }
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

    private function dumpException(\Exception $e)
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
