<?php
/**
 * This file is part of Replum: the web widget framework.
 *
 * Copyright (c) Dennis Birkholz <dennis@birkholz.org>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Replum;

use PHPUnit\Framework\TestCase;
use Replum\Events\WidgetAddEvent;

/**
 * Tests that hierarchy managements works:
 * - adding and removing nodes
 * - adding and removing subtrees
 * - sending, handing and processing the required events
 */
class HierarchyTest extends TestCase
{
    public function testSimpleAddDel()
    {
        $page = new PageMock(new Context());
        $this->assertTrue($page->isRoot());
        $this->assertFalse($page->hasParent());
        $this->assertSame($page, $page->getPage());

        $widget1 = new WidgetMock();
        $this->assertTrue($widget1->isDetached());
        $this->assertFalse($widget1->isRoot());
        $this->assertFalse($widget1->hasParent());

        try {
            $widget1->getPage();
            $this->fail("Page access to detached widget must fail!");
        } catch (WidgetDetachedException $e) {
        }

        try {
            $widget1->getParent();
            $this->fail("Access to parent of orphaned widget must fail!");
        } catch (\InvalidArgumentException $e) {
        }

        $page->add($widget1);

        $this->assertFalse($widget1->isDetached());
        $this->assertFalse($widget1->isRoot());
        $this->assertSame($page, $widget1->getPage());
        $this->assertSame($page, $widget1->getParent());

        $widget2 = new WidgetMock();
        $this->assertTrue($widget2->isDetached());
        $this->assertFalse($widget2->hasParent());

        $widget1->add($widget2);
        $this->assertFalse($widget2->isDetached());
        $this->assertSame($widget1, $widget2->getParent());
        $this->assertSame($page, $widget2->getPage());
    }

    /**
     * @test
     */
    public function testGetAncestors()
    {
        $page = new PageMock(new Context());
        $page->add($widget1 = new WidgetMock());
        $page->add($widget2 = new WidgetMock());

        $widget1->add($widget1_1 = new WidgetMock());
        $widget1->add($widget1_2 = new WidgetMock());
        $widget1->add($widget1_3 = new WidgetMock());

        $widget2->add($widget2_1 = new WidgetMock());
        $widget2->add($widget2_2 = new WidgetMock());
        $widget2->add($widget2_3 = new WidgetMock());
        $widget2->add($widget2_4 = new WidgetMock());
        $widget2->add($widget2_5 = new WidgetMock());

        $widget2_2->add($widget2_2_1 = new WidgetMock());
        $widget2_2->add($widget2_2_2 = new WidgetMock());

        $ref = [$widget2_2, $widget2, $page];
        $widget = $widget2_2_1;
        $ancestors = [];

        foreach ($widget2_2_1->getAncestors() as $ancestor) {
            $this->assertSame(($widget->hasParent() ? $widget->getParent() : null), $ancestor);
            $widget = $ancestor;
            $ancestors[] = $ancestor;
        }

        $this->assertSame($ref, $ancestors);
    }

    /**
     * @test
     */
    public function testEvents()
    {
        $page = new PageMock(new Context());
        $addHandlerOnPageCalled = false;

        $page->on(WidgetAddEvent::class, function (WidgetAddEvent $event) use (&$addHandlerOnPageCalled) {
            $addHandlerOnPageCalled = true;
        });

        $widget1 = new WidgetMock();

        $page->add($widget1);
        $this->assertTrue($addHandlerOnPageCalled);
    }

    /**
     * @test
     */
    public function testFindById()
    {
        $page = new PageMock(new Context());
        $page->add($widget1 = new WidgetMock());
        $page->add($widget2 = new WidgetMock());

        $widget1->add($widget1_1 = new WidgetMock());
        $widget1->add($widget1_2 = new WidgetMock());
        $widget1->add($widget1_3 = new WidgetMock());

        $widget2->add($widget2_1 = new WidgetMock());
        $widget2->add($widget2_2 = new WidgetMock());
        $widget2->add($widget2_3 = new WidgetMock());
        $widget2->add($widget2_4 = new WidgetMock());
        $widget2->add($widget2_5 = new WidgetMock());

        $widget2_2->add($widget2_2_1 = new WidgetMock());
        $widget2_2->add($widget2_2_2 = new WidgetMock());

        $this->assertSame($widget1, $page->findById($widget1->getWidgetId()));
        $this->assertSame($widget2_4, $page->findById($widget2_4->getWidgetId()));
        $this->assertSame($widget2_2_1, $page->findById($widget2_2_1->getWidgetId()));
    }

    /**
     * @test
     */
    public function testGetDescendants()
    {
        $page = new PageMock(new Context());
        $page->add($widget1 = new WidgetMock());
        $page->add($widget2 = new WidgetMock());

        $widget1->add($widget1_1 = new WidgetMock());
        $widget1->add($widget1_2 = new WidgetMock2());
        $widget1->add($widget1_3 = new WidgetMock());

        $widget2->add($widget2_1 = new WidgetMock());
        $widget2->add($widget2_2 = new WidgetMock());
        $widget2->add($widget2_3 = new WidgetMock());
        $widget2->add($widget2_4 = new WidgetMock2());
        $widget2->add($widget2_5 = new WidgetMock());

        $widget2_2->add($widget2_2_1 = new WidgetMock());
        $widget2_2->add($widget2_2_2 = new WidgetMock2());

        $descendants = [];
        foreach ($widget2_2->getDescendants() as $descendant) {
            $descendants[] = $descendant;
        }
        $this->assertSame([$widget2_2_1, $widget2_2_2], $descendants);

        $depthFirst = [$widget1, $widget1_1, $widget1_2, $widget1_3, $widget2, $widget2_1, $widget2_2, $widget2_2_1, $widget2_2_2, $widget2_3, $widget2_4, $widget2_5];
        foreach ($page->getDescendants() as $descendant) {
            $this->assertSame(\array_shift($depthFirst), $descendant);
        }
        $this->assertEmpty($depthFirst);

        $breadthFirst = [$widget1, $widget2, $widget1_1, $widget1_2, $widget1_3, $widget2_1, $widget2_2, $widget2_3, $widget2_4, $widget2_5, $widget2_2_1, $widget2_2_2];
        foreach ($page->getDescendants(null, true) as $descendant) {
            $this->assertSame(\array_shift($breadthFirst), $descendant);
        }
        $this->assertEmpty($breadthFirst);

        $unfiltered = [$widget1, $widget1_1, $widget1_2, $widget1_3, $widget2, $widget2_1, $widget2_2, $widget2_2_1, $widget2_2_2, $widget2_3, $widget2_4, $widget2_5];
        foreach ($page->getDescendants(WidgetInterface::class) as $descendant) {
            $this->assertSame(\array_shift($unfiltered), $descendant);
        }
        $this->assertEmpty($unfiltered);

        $depthFirstFiltered = [$widget1_2, $widget2_2_2, $widget2_4];
        foreach ($page->getDescendants(WidgetMock2::class) as $descendant) {
            $this->assertSame(\array_shift($depthFirstFiltered), $descendant);
        }
        $this->assertEmpty($depthFirstFiltered);

        $breadthFirstFiltered = [$widget1_2, $widget2_4, $widget2_2_2];
        foreach ($page->getDescendants(WidgetMock2::class, true) as $descendant) {
            $this->assertSame(\array_shift($breadthFirstFiltered), $descendant);
        }
        $this->assertEmpty($breadthFirstFiltered);
    }
}
