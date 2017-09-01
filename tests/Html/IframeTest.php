<?php
/**
 * This file is part of Replum: the web widget framework.
 *
 * Copyright (c) Dennis Birkholz <dennis@birkholz.org>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Replum\Html;

use \Replum\HtmlFactory;

class IframeTest extends HtmlTestBase
{
    /**
     * @return Iframe
     */
    protected function factory() : HtmlElement
    {
        return HtmlFactory::iframe($this->page);
    }

    protected $attributes = [
        "sandbox"        => true,
        "src"            => ["http://localhost", "https://example.com"],
        "srcdoc"         => ["<html><body><b>Hallo</b></body></html>", "<html><body><p>Test</p></body></html>"],
        "name"           => ["foo", "bar"],
        "width"          => [20, 10],
        "height"         => [10, 20],
        "scrolling"      => [Iframe::SCROLLING_AUTO, Iframe::SCROLLING_YES, Iframe::SCROLLING_NO],
    ];

    /**
     * Additional test for the sandbox attributes as it can also contain a list of features to allow
     *
     * @test
     */
    public function testSandboxAttribute()
    {
        $element = $this->factory();

        $this->assertFalse($element->getSandbox());
        $this->assertSame($element, $element->addSandboxFeature(Iframe::SANDBOX_ALLOW_FORMS));
        $this->assertTrue($element->getSandbox());
        $this->assertEquals([Iframe::SANDBOX_ALLOW_FORMS], $element->getSandboxFeatures());

        $element->addSandboxFeature(...Iframe::SANDBOX_FEATURES);
        $this->assertEquals(Iframe::SANDBOX_FEATURES, $element->getSandboxFeatures());
        $this->assertSame($element, $element->delSandboxFeature(Iframe::SANDBOX_ALLOW_SCRIPTS));
        $this->assertNotContains(Iframe::SANDBOX_ALLOW_SCRIPTS, $element->getSandboxFeatures());

        $this->assertSame($element, $element->clearSandboxFeatures());
        $this->assertEquals([], $element->getSandboxFeatures());

        try {
            $element->addSandboxFeature('invalid-feature');
            $this->fail('Setting invalid features should be disallowed!');
        } catch (\InvalidArgumentException $e) {
            $this->assertTrue(true);
        }

        try {
            $element->delSandboxFeature('invalid-feature');
            $this->fail('Removing invalid features should be disallowed!');
        } catch (\InvalidArgumentException $e) {
            $this->assertTrue(true);
        }
    }
}
