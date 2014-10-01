<?php

/*
 * This file is part of the nexxes/widgets package.
 *
 * Copyright (C) 2014 Dennis Birkholz <dennis.birkholz@nexxes.net>.
 *
 * This library is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Lesser General Public License as
 * published by the Free Software Foundation, either version 3 of
 * the License, or (at your option) any later version.
 *
 * This library is distributed in the hope that it will be useful, but
 * WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 * See the GNU Lesser General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public
 * License along with this library; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston,
 * MA 02110-1301  USA
 */

namespace nexxes\widgets;

/**
 * @author Dennis Birkholz <dennis.birkholz@nexxes.net>
 */
class WidgetLifecycleEventsTest extends \PHPUnit_Framework_TestCase {
	private $events = [];
	
	/**
	 * @return PageTraitMock
	 */
	protected function createPage() {
		$instance = $this;
		$this->events = [];
		
		$page = new PageTraitMock();
		$eventDispatcher = $page->getEventDispatcher();
		$eventDispatcher->addListener(events\WidgetAddEvent::class, function ($event, $eventName, $dispatcher) use ($instance) { $instance->events[] = $event; });
		$eventDispatcher->addListener(events\WidgetRemoveEvent::class, function ($event, $eventName, $dispatcher) use ($instance) { $instance->events[] = $event; });
		$eventDispatcher->addListener(events\WidgetReplaceEvent::class, function ($event, $eventName, $dispatcher) use ($instance) { $instance->events[] = $event; });
		
		return $page;
	}
	
	/**
	 * @test
	 */
	public function testAddWidget() {
		$page = $this->createPage();
		
		// Container is added to page
		$container = new WidgetContainer($page);
		$this->assertCount(1, $this->events);
		$event = \array_shift($this->events);
		$this->assertInstanceOf(events\WidgetAddEvent::class, $event);
		$this->assertSame($event->parent, $page);
		$this->assertSame($event->widget, $container);
		
		// Widget is added to container
		$widget1 = new WidgetTraitMock($container);
		$this->assertSame($container, $widget1->getParent());
		$this->assertSame($container->children()[0], $widget1);
		
		$this->assertCount(1, $this->events);
		$event = \array_shift($this->events);
		$this->assertInstanceOf(events\WidgetAddEvent::class, $event);
		$this->assertSame($event->parent, $container);
		$this->assertSame($event->widget, $widget1);
	}
	
	/**
	 * @test
	 */
	public function testRemoveWidget() {
		$page = $this->createPage();
		
		$container = new WidgetContainer($page);
		$widget1 = new WidgetTraitMock($container);
		
		$this->events = [];
		
		// Remove widget from container
		unset($container->children()[0]);
		$this->assertCount(1, $this->events);
		$event = \array_shift($this->events);
		$this->assertInstanceOf(events\WidgetRemoveEvent::class, $event);
		$this->assertSame($event->parent, $container);
		$this->assertSame($event->widget, $widget1);
	}
	
	/**
	 * @test
	 */
	public function testWidgetMove() {
		$page = $this->createPage();
		
		$container1 = new WidgetContainer($page);
		$container2 = new WidgetContainer($page);
		$widget1 = new WidgetTraitMock($container1);
		
		$this->events = [];
		
		// Move widget to new container
		$container2->children()->add($widget1);
		
		$this->assertCount(2, $this->events);
		
		$event = \array_shift($this->events);
		$this->assertInstanceOf(events\WidgetRemoveEvent::class, $event);
		$this->assertSame($event->parent, $container1);
		$this->assertSame($event->widget, $widget1);
		
		$event = \array_shift($this->events);
		$this->assertInstanceOf(events\WidgetAddEvent::class, $event);
		$this->assertSame($event->parent, $container2);
		$this->assertSame($event->widget, $widget1);
	}
	
	/**
	 * @test
	 */
	public function testWidgetReplace() {
		$page = $this->createPage();
		
		$container1 = new WidgetContainer($page);
		$widget1 = new WidgetTraitMock($container1);
		
		$this->events = [];
		
		$widget2 = new WidgetTraitMock();
		$container1->children()->replace($widget1, $widget2);
		
		$this->assertCount(3, $this->events);
		
		$event = \array_shift($this->events);
		$this->assertInstanceOf(events\WidgetRemoveEvent::class, $event);
		$this->assertSame($event->parent, $container1);
		$this->assertSame($event->widget, $widget1);
		
		$event = \array_shift($this->events);
		$this->assertInstanceOf(events\WidgetReplaceEvent::class, $event);
		$this->assertSame($event->parent, $container1);
		$this->assertSame($event->old, $widget1);
		$this->assertSame($event->new, $widget2);
		
		$event = \array_shift($this->events);
		$this->assertInstanceOf(events\WidgetAddEvent::class, $event);
		$this->assertSame($event->parent, $container1);
		$this->assertSame($event->widget, $widget2);
	}
}
