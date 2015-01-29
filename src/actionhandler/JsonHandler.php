<?php

namespace nexxes\widgets\actionhandler;

use \nexxes\widgets\Event;
use \nexxes\widgets\events\WidgetOnChangeEvent;
use \nexxes\widgets\events\WidgetOnClickEvent;
use \nexxes\widgets\events\WidgetOnDoubleClickEvent;
use \nexxes\widgets\events\WidgetOnSubmitEvent;

/**
 * @author Dennis Birkholz <dennis.birkholz@nexxes.net>
 */
class JsonHandler
{

    /**
     * @var \nexxes\widgets\Executer
     */
    private $executer;

    public function __construct(\nexxes\widgets\Executer $executer)
    {
        $this->executer = $executer;
    }

    public function execute()
    {
        try {
            /* $var $request \Symfony\Component\HttpFoundation\Request */
            $request = $this->executer->getRequest();

            $event = $request->request->get('nexxes_event');

            if (!\in_array($event, ['click', 'change', 'dblclick', 'submit',])) {
                throw new \InvalidArgumentException('Invalid event with name "' . $event . '"');
            }

            $page_id = $request->request->get('nexxes_pid');

            /* @var $page \nexxes\widgets\PageInterface */
            //$page = \apc_fetch($this->executer->getCacheNamespace() . '.' . $page_id);
            $page = \unserialize(\gzinflate(\apc_fetch($this->executer->getCacheNamespace() . '.' . $page_id)));

            if (!($page instanceof \nexxes\widgets\PageInterface)) {
                throw new \RuntimeException('Can not restore page!');
            }

            $widget = $page->findById($request->request->get('nexxes_source'));
            if ($request->request->get('nexxes_value') !== null) {
                $widget->setValue($request->request->get('nexxes_value'));
            } elseif ($request->request->get('nexxes_checked') !== null) {
                $widget->setChecked($request->request->get('nexxes_checked'));
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

            //\apc_store($this->executer->getCacheNamespace() . '.' . $page->id, $page, 0);
            \apc_store($this->executer->getCacheNamespace() . '.' . $page->id, \gzdeflate(\serialize($page)), 0);
        } catch (\Exception $e) {
            $data = [[
                    'nexxes_action' => 'error',
                    'nexxes_params' => [$this->dumpException($e)],
            ]];
        }

        header('Content-Type: text/json');
        echo json_encode($data);

        exit;
    }

    protected function handleChangedWidgets(\nexxes\widgets\PageInterface $page)
    {
        $data = [];

        foreach ($page->getDescendants() as $widget) {
            /* @var $widget \nexxes\widgets\WidgetInterface */
            if ($widget->isChanged() && $widget->hasID()) {
                $data[] = [
                    'nexxes_action' => 'replace',
                    'nexxes_target' => $widget->getID(),
                    'nexxes_data' => (string) $widget,
                ];
            }
        }

        foreach ($page->remoteActions as list($action, $parameters)) {
            $data[] = [
                'nexxes_action' => $action,
                'nexxes_params' => $parameters,
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
