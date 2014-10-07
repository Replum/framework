<?php

namespace nexxes\widgets\actionhandler;

use \nexxes\widgets\Event;

use \nexxes\widgets\events\WidgetOnChangeEvent;
use \nexxes\widgets\events\WidgetOnClickEvent;

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
		
		if (!\in_array($event, ['click', 'change'])) {
			throw new \InvalidArgumentException('Invalid event with name "' . $event . '"');
		}
		
		$page_id = $request->request->get('nexxes_pid');
		
		/* @var $page \nexxes\widgets\PageInterface */
		$page = \apc_fetch($this->executer->getCacheNamespace() . '.' . $page_id);

		if (!($page instanceof \nexxes\widgets\PageInterface)) {
			throw new \RuntimeException('Can not restore page!');
		}

		$widget = $page->getWidgetRegistry()->getWidget($request->request->get('nexxes_source'));
		if ($request->request->get('nexxes_value')) {
			$widget->setValue($request->request->get('nexxes_value'));
		}
		
		if ($event == 'click') {
			$page->getEventDispatcher()->dispatch(WidgetOnClickEvent::class . ':' . $widget->getID(), new WidgetOnClickEvent($widget));
		} elseif ($event == 'change') {
			$page->getEventDispatcher()->dispatch(WidgetOnChangeEvent::class . ':' . $widget->getID(), new WidgetOnChangeEvent($widget));
		}
		
		$data = $this->handleChangedWidgets($page->getWidgetRegistry());

		header('Content-Type: text/json');
		echo json_encode($data);
		
		\apc_store($this->executer->getCacheNamespace() . '.' . $page->id, $page, 0);
		exit;
	}
	
	protected function handleChangedWidgets(\nexxes\widgets\WidgetRegistry $registry) {
		$data = [];
		
		foreach ($registry AS $widget) {
			/* @var $widget \nexxes\widgets\WidgetInterface */
			if ($widget->isChanged()) {
				/* @var $widget \nexxes\widgets\bootstrap\FormGroup */
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
