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

abstract class HtmlTestBase extends TestCase
{
    /**
     * @var PageMock
     */
    protected $page;

    /**
     * Attributes to check for, sample list for input elements
     *
     * @var array
     */
    protected $attributes = [
        // Common attributes
        "autofocus"      => true,
        "disabled"       => true,
        "form"           => null,
        "name"           => ["foo", "bar"],
        "value"          => ["foo", "bar"],

        "accept"         => null,
        "alt"            => null,
        "autocomplete"   => [Form::AUTOCOMPLETE_ON, Form::AUTOCOMPLETE_OFF],
        "checked"        => true,
        "dirname"        => ["foo", "bar"],
        "formaction"     => ["foo", "bar"],
        "formenctype"    => ["foo", "bar"],
        "formmethod"     => ["foo", "bar"],
        "formnovalidate" => ["foo", "bar"],
        "formtarget"     => ["foo", "bar"],
        "height"         => [20, 10],
        "inputmode"      => ["foo", "bar"],
        "list"           => ["foo", "bar"],
        "max"            => [20, 10],
        "maxlength"      => [20, 10],
        "min"            => [10, 20],
        "minlength"      => [10, 20],
        "multiple"       => true,
        "pattern"        => ["foo bar", "/blubb/baz/"],
        "placeholder"    => ["placeholder I am", "Stupid text"],
        "readonly"       => true,
        "required"       => true,
        "size"           => [5, 10],
        "src"            => ["foo", "bar"],
        "step"           => [5, 10],
        "width"          => [5, 10],
    ];

    protected $additionalAttributes = [];

    public function setUp()
    {
        $this->page = new PageMock(new Context());
    }

    abstract protected function factory() : HtmlElement;

    private function makeAccessor(string $prefix, string $attribute) : string
    {
        return $prefix . \implode('', \array_map('ucfirst', \explode('-', $attribute)));
    }

    final protected function runBoolAttributeTest(string $attributeName)
    {
        $getter = $this->makeAccessor('get', $attributeName);
        $setter = $this->makeAccessor('set', $attributeName);

        $input = $this->factory();

        $this->assertFalse($input->{$getter}());

        $this->assertSame($input, $input->{$setter}(true));
        $this->assertTrue($input->{$getter}());

        $this->assertSame($input, $input->{$setter}(false));
        $this->assertFalse($input->{$getter}());

        $this->assertSame($input, $input->{$setter}(true));
        $this->assertTrue($input->{$getter}());

        try {
            $input->{$setter}(null);
            $this->assertTrue(false, "Should not be allowed to set attribute $attributeName to NULL.");
        } catch (\TypeError $e) {
            $this->assertTrue(true);
        }
    }

    final protected function runNullableAttributeTest(string $attributeName, ...$values)
    {
        $getter = $this->makeAccessor('get', $attributeName);
        $hasser = $this->makeAccessor('has', $attributeName);
        $setter = $this->makeAccessor('set', $attributeName);

        $input = $this->factory();

        $this->assertFalse($input->{$hasser}());

        foreach ($values as $value) {
            $this->assertSame($input, $input->{$setter}($value));
            $this->assertTrue($input->{$hasser}());
            $this->assertEquals($value, $input->{$getter}());
        }

        $this->assertSame($input, $input->{$setter}(null));
        $this->assertFalse($input->{$hasser}());

        try {
            $input->{$getter}();
            $this->assertTrue(false, "Should not be allowed to get NULL attribute $attributeName.");
        } catch (\TypeError $e) {
            $this->assertTrue(true);
        }
    }

    /**
     * @test
     */
    public function testAttributes()
    {
        foreach ($this->attributes as $attribute => $values) {
            if ($values === true) {
                $this->runBoolAttributeTest($attribute);
            }

            elseif ($values !== null) {
                $this->runNullableAttributeTest($attribute, ...$values);
            }
        }
    }

    /**
     * @test
     */
    public function testMissingAttributes()
    {
        $missing = [];

        foreach ($this->attributes as $attribute => $value) {
            if ($value === null) {
                $missing[] = $attribute;
            }
        }

        if (\count($missing)) {
            $this->markTestIncomplete("Tests for attributes missing: " . \implode(', ', $missing));
        } else {
            $this->assertTrue(true);
        }
    }

    /**
     * @test
     */
    public function testRendering()
    {
        $ref = $this->additionalAttributes;
        $element = $this->factory();

        foreach ($this->attributes as $attribute => $values) {
            if (\is_null($values)) {
                continue;
            }

            $setter = $this->makeAccessor('set', $attribute);
            if (\is_array($values)) {
                $element->{$setter}($values[0]);
                $ref[$attribute] = (string)$values[0];
            }

            else {
                $element->{$setter}($values);
                $ref[$attribute] = $values;
            }
        }

        $attributes = self::getAttributesForTag($element->render(), $element::TAG);
        $this->assertEquals($ref, $attributes);
    }

    public static function getAttributesForTag(string $html, string $tagName) : array
    {
        $parsed = \DOMDocument::loadHtml($html);
        $dom = $parsed->getElementsByTagName($tagName)[0];
        $attributes = [];

        foreach ($dom->attributes as $attribute) {
            $attributes[$attribute->name] = ($attribute->value == $attribute->name || $attribute->value === '' ? true : $attribute->value);
        }

        return $attributes;
    }
}
