<?php

namespace nexxes\widgets\traits;

use \nexxes\dependency\Gateway as dep;
use \nexxes\widgets\WidgetRegistry;
use \nexxes\widgets\Event;

use \Symfony\Component\EventDispatcher\EventDispatcherInterface;
use \Symfony\Component\EventDispatcher\EventDispatcher;

require_once(__DIR__ . '/WidgetHasEventsMock.php');
require_once(__DIR__ . '/EventHandlerMock.php');

class WidgetHasEventsTest extends \PHPUnit_Framework_TestCase {
	public function setUp() {
		parent::setUp();
		
		$dispatcher = new EventDispatcher();
		dep::registerObject(EventDispatcherInterface::class, $dispatcher);
		
		$registry = new WidgetRegistry();
		dep::registerObject(WidgetRegistry::class, $registry);
	}
	
	/**
	 * @covers \nexxes\widgets\traits\WidgetHasEvents::registerEventHandler
	 * @covers \nexxes\widgets\traits\WidgetHasEvents::removeEventHandler
	 */
	public function testRegisterEventHandler() {
		$widget = new WidgetHasEventsMock();
		dep::get(WidgetRegistry::class)->register($widget);
		
		$handler = new EventHandlerMock();
		$eventName = __FUNCTION__ . '_testevent';
		$realEventName = 'widget.' . $widget->getID() . '.' . $eventName;
		
		$widget->registerEventHandler($eventName, [$handler, 'handler']);
		
		$this->assertNotEquals($realEventName, $handler->eventname);
		$this->assertEquals(0, $handler->counter, true);
		
		/* @var $dispatcher EventDispatcherInterface */
		$dispatcher = dep::get(EventDispatcherInterface::class);
		
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
	 * @covers \nexxes\widgets\traits\WidgetHasEvents::registerOnceEventHandler
	 */
	public function testRegisterOnceEventHandler() {
		$widget = new WidgetHasEventsMock();
		dep::get(WidgetRegistry::class)->register($widget);
		
		$handler = new EventHandlerMock();
		$eventName = __FUNCTION__ . '_testevent';
		$realEventName = 'widget.' . $widget->getID() . '.' . $eventName;
		
		$widget->registerOnceEventHandler($eventName, [$handler, 'handler']);
		
		$this->assertNotEquals($realEventName, $handler->eventname);
		$this->assertEquals(0, $handler->counter, true);
		
		/* @var $dispatcher EventDispatcherInterface */
		$dispatcher = dep::get(EventDispatcherInterface::class);
		
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
	 * @covers \nexxes\widgets\traits\WidgetHasEvents::removeOnceEventHandler
	 */
	public function testRemoveOnceEventHandler() {
		$widget = new WidgetHasEventsMock();
		dep::get(WidgetRegistry::class)->register($widget);
		
		$handler = new EventHandlerMock();
		$eventName = __FUNCTION__ . '_testevent';
		$realEventName = 'widget.' . $widget->getID() . '.' . $eventName;
		
		/* @var $dispatcher EventDispatcherInterface */
		$dispatcher = dep::get(EventDispatcherInterface::class);
		
		$widget->registerOnceEventHandler($eventName, [$handler, 'handler']);
		$this->assertCount(1, $dispatcher->getListeners($realEventName));
		
		$widget->removeOnceEventHandler($eventName, [$handler, 'handler']);
		$this->assertCount(0, $dispatcher->getListeners($realEventName));
		
		$dispatcher->dispatch($realEventName, new Event($widget));
		$this->assertEquals('', $handler->eventname);
		$this->assertEquals(0, $handler->counter, true);
	}
}
