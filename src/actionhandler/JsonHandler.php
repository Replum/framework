<?php

namespace nexxes\widgets\actionhandler;

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
		
		if ($event != "change") {
			throw new \InvalidArgumentException('Invalid event with name "' . $event . '"');
		}
		
		$page_id = $request->request->get('nexxes_pid');
		
		/* @var $page interfaces\Page */
		$page = \apc_fetch($this->executer->getCacheNamespace() . '.' . $page_id);

		if (!($page instanceof \nexxes\widgets\interfaces\Page)) {
			throw new \RuntimeException('Can not restore page!');
		}

		$widget = $page->getWidgetRegistry()->getWidget($request->request->get('nexxes_source'));
		$widget->setValue($request->request->get($widget->getName()));
		
		if ($widget->getValue() == 'test') {
			$widget->getParent()->addClass('has-success')->delClass('has-error');
		} else {
			$widget->getParent()->addClass('has-error')->delClass('has-success');
		}
		
		$data = [];
		$data[] = [
			'nexxes_action' => 'replace',
			'nexxes_target' => $widget->getParent()->getID(),
			'nexxes_data' => (string)$widget->getParent(),
		];

		header('Content-Type: text/json');
		echo json_encode($data);
		exit;
	}
}
