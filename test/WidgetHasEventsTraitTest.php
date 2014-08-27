<?php

namespace nexxes\widgets;

use \nexxes\dependency\Gateway as dep;
use \nexxes\widgets\WidgetRegistry;
use \nexxes\widgets\Event;

use \Symfony\Component\EventDispatcher\EventDispatcherInterface;
use \Symfony\Component\EventDispatcher\EventDispatcher;

/**
 * @coversDefaultClass \nexxes\widgets\WidgetHasEventsTrait
 */
class WidgetHasEventsTraitTest extends \PHPUnit_Framework_TestCase {
	public function setUp() {
		parent::setUp();
		
		$dispatcher = new EventDispatcher();
		dep::registerObject(EventDispatcherInterface::class, $dispatcher);
		
		$registry = new WidgetRegistry();
		dep::registerObject(WidgetRegistry::class, $registry);
	}
	
	/**
	 * @covers ::registerEventHandler
	 * @covers ::removeEventHandler
	 */
	public function testRegisterEventHandler() {
		$page = new PageTraitMock();
		
		$widget = (new WidgetHasEventsTraitMock())->setParent($page);
		$page->getWidgetRegistry()->register($widget);
		
		$handler = new EventHandlerMock();
		$eventName = __FUNCTION__ . '_testevent';
		$realEventName = 'widget.' . $widget->getID() . '.' . $eventName;
		
		$widget->registerEventHandler($eventName, [$handler, 'handler']);
		
		$this->assertNotEquals($realEventName, $handler->eventname);
		$this->assertEquals(0, $handler->counter, true);
		
		/* @var $dispatcher EventDispatcherInterface */
		$dispatcher = $page->getEventDispatcher();
		
		$max_counter = 10;
		
		for ($i=1; $i<=$max_counter; $i++) {
			$dispatcher->dispatch($realEventName, new Event($widget));
			
			$this->assertEquals($realEventName, $handler->eventname);
			$this->assertEquals($i, $handler->counter, true);
			
			$handler->eventname = '';
		}
		
		$widget->removeEventHandler($eventName, [$handler, 'handler']);
		
		$dispatcher->dispatch($realEventName, new Event($widget));
		
		$this->assertEquals('', $handler->eventname);
		$this->assertEquals($max_counter, $handler->counter, true);
	}
	
	/**
	 * @covers ::registerOnceEventHandler
	 */
	public function testRegisterOnceEventHandler() {
		$page = new PageTraitMock();
		
		$widget = (new WidgetHasEventsTraitMock())->setParent($page);
		$page->getWidgetRegistry()->register($widget);
		
		$handler = new EventHandlerMock();
		$eventName = __FUNCTION__ . '_testevent';
		$realEventName = 'widget.' . $widget->getID() . '.' . $eventName;
		
		$widget->registerOnceEventHandler($eventName, [$handler, 'handler']);
		
		$this->assertNotEquals($realEventName, $handler->eventname);
		$this->assertEquals(0, $handler->counter, true);
		
		/* @var $dispatcher EventDispatcherInterface */
		$dispatcher = $page->getEventDispatcher();
		
		$dispatcher->dispatch($realEventName, new Event($widget));
		$this->assertEquals($realEventName, $handler->eventname);
		$this->assertEquals(1, $handler->counter, true);
		
		$this->assertCount(0, $dispatcher->getListeners($realEventName));
		
		$handler->eventname = '';
		
		$dispatcher->dispatch($realEventName, new Event($widget));
		$this->assertEquals('', $handler->eventname);
		$this->assertEquals(1, $handler->counter, true);
	}
	
	/**
	 * @covers ::removeOnceEventHandler
	 */
	public function testRemoveOnceEventHandler() {
		$page = new PageTraitMock();
		
		$widget = (new WidgetHasEventsTraitMock())->setParent($page);
		$page->getWidgetRegistry()->register($widget);
		
		$handler = new EventHandlerMock();
		$eventName = __FUNCTION__ . '_testevent';
		$realEventName = 'widget.' . $widget->getID() . '.' . $eventName;
		
		/* @var $dispatcher EventDispatcherInterface */
		$dispatcher = $page->getEventDispatcher();
		
		$widget->registerOnceEventHandler($eventName, [$handler, 'handler']);
		$this->assertCount(1, $dispatcher->getListeners($realEventName));
		
		$widget->removeOnceEventHandler($eventName, [$handler, 'handler']);
		$this->assertCount(0, $dispatcher->getListeners($realEventName));
		
		$dispatcher->dispatch($realEventName, new Event($widget));
		$this->assertEquals('', $handler->eventname);
		$this->assertEquals(0, $handler->counter, true);
	}
}
