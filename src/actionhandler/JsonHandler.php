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
class JsonHandler {
	/**
	 * @var \nexxes\widgets\Executer
	 */
	private $executer;
	
	public function __construct(\nexxes\widgets\Executer $executer) {
		$this->executer = $executer;
	}
	
	public function execute() {
		/* $var $request \Symfony\Component\HttpFoundation\Request */
		$request = $this->executer->getRequest();
		
		$event = $request->request->get('nexxes_event');
		
		if (!\in_array($event, ['click', 'change', 'dblclick', 'submit', ])) {
			throw new \InvalidArgumentException('Invalid event with name "' . $event . '"');
		}
		
		$page_id = $request->request->get('nexxes_pid');
		
		/* @var $page \nexxes\widgets\PageInterface */
		$page = \unserialize(\gzinflate(\apc_fetch($this->executer->getCacheNamespace() . '.' . $page_id)));

		if (!($page instanceof \nexxes\widgets\PageInterface)) {
			throw new \RuntimeException('Can not restore page!');
		}

		$widget = $page->getWidgetRegistry()->getWidget($request->request->get('nexxes_source'));
		if ($request->request->get('nexxes_value') !== null) {
			$widget->setValue($request->request->get('nexxes_value'));
		}
		elseif ($request->request->get('nexxes_checked') !== null) {
			$widget->setChecked($request->request->get('nexxes_checked'));
		}
		
		
		if ($event == 'click') {
			$page->getEventDispatcher()->dispatch(WidgetOnClickEvent::class, new WidgetOnClickEvent($widget));
		} elseif ($event == 'change') {
			$page->getEventDispatcher()->dispatch(WidgetOnChangeEvent::class, new WidgetOnChangeEvent($widget));
		} elseif ($event == 'dblclick') {
			$page->getEventDispatcher()->dispatch(WidgetOnDoubleClickEvent::class, new WidgetOnDoubleClickEvent($widget));
		} elseif ($event == 'submit') {
			$page->getEventDispatcher()->dispatch(WidgetOnSubmitEvent::class, new WidgetOnSubmitEvent($widget));
		}
		
		$data = $this->handleChangedWidgets($page->getWidgetRegistry());

		header('Content-Type: text/json');
		echo json_encode($data);
		
		//\apc_store($this->executer->getCacheNamespace() . '.' . $page->id, $page, 0);
		\apc_store($this->executer->getCacheNamespace() . '.' . $page->id, \gzdeflate(\serialize($page)), 0);
		exit;
	}
	
	protected function handleChangedWidgets(\nexxes\widgets\WidgetRegistry $registry) {
		$data = [];
		
		foreach ($registry AS $widget) {
			/* @var $widget \nexxes\widgets\WidgetInterface */
			if ($widget->isChanged()) {
				$data[] = [
					'nexxes_action' => 'replace',
					'nexxes_target' => $widget->getID(),
					'nexxes_data' => (string)$widget,
				];
			}
		}
		
		return $data;
	}
}
