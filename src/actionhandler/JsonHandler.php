<?php

namespace nexxes\widgets\actionhandler;

use \nexxes\widgets\Event;

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
		
		$page->getEventDispatcher()->dispatch('widget.' . $widget->getID() . '.on' . $event, new Event($widget));
		
		$data = $this->handleChangedWidgets($page->getWidgetRegistry());

		header('Content-Type: text/json');
		echo json_encode($data);
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
