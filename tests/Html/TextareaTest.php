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

use \PHPUnit\Framework\TestCase;
use \Replum\Context;
use \Replum\HtmlFactory;
use Symfony\Component\Console\Tests\Input\InputTest;

class TextareaTest extends HtmlTestBase
{
    /**
     * @return Textarea
     */
    protected function factory() : HtmlElement
    {
        return HtmlFactory::textarea($this->page);
    }

    protected $attributes = [
        // Common attributes
        "autofocus"      => true,
        "disabled"       => true,
        "form"           => null,
        "name"           => ["foo", "bar"],

        "autocomplete"   => [Form::AUTOCOMPLETE_ON, Form::AUTOCOMPLETE_OFF],
        "cols"           => [20, 10],
        "dirname"        => null,
        "inputmode"      => null,
        "maxlength"      => [20, 10],
        "minlength"      => [10, 20],
        "placeholder"    => ["placeholder I am", "Stupid text"],
        "readonly"       => true,
        "required"       => true,
        "rows"           => [5, 10],
        "wrap"           => [Textarea::WRAP_SOFT, Textarea::WRAP_HARD],
    ];

    /**
     * Special handling for text area value (that is written as element content, not value attribute)
     *
     * @test
     */
    public function testValue()
    {
        $values = [
            "simple text",
            "text with\n\nnewlines\n",
            "text with <pre>html</pre> which must be escaped\nand a newline\nand a <textarea>textarea</textarea> element",
        ];

        $element = $this->factory();

        foreach ($values as $value) {
            $this->assertSame($element, $element->setValue($value));
            $this->assertTrue($element->hasValue());
            $this->assertSame($value, $element->getValue());

            $parsed = \DOMDocument::loadHtml($element->render());
            $dom = $parsed->getElementsByTagName($element::TAG)[0];
            $this->assertEquals($value, $dom->nodeValue);
        }
    }
}
