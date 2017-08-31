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

class TextInputTest extends TestCase
{
    private $page;

    public function setUp()
    {
        $this->page = new PageMock(new Context());
    }

    private function factory() : TextInput
    {
        return HtmlFactory::textInput($this->page);
    }

    /**
     * @test
     * @covers \Replum\Html\InputAutocompleteAttributeTrait::getAutocomplete()
     * @covers \Replum\Html\InputAutocompleteAttributeTrait::hasAutocomplete()
     * @covers \Replum\Html\InputAutocompleteAttributeTrait::setAutocomplete()
     */
    public function testAutocompleteAttribute()
    {
        $input = $this->factory();

        $this->assertFalse($input->hasAutocomplete());

        $this->assertSame($input, $input->setAutocomplete(Input::AUTOCOMPLETE_ON));
        $this->assertTrue($input->hasAutocomplete());
        $this->assertEquals(Input::AUTOCOMPLETE_ON, $input->getAutocomplete());

        $this->assertSame($input, $input->setAutocomplete(Input::AUTOCOMPLETE_OFF));
        $this->assertTrue($input->hasAutocomplete());
        $this->assertEquals(Input::AUTOCOMPLETE_OFF, $input->getAutocomplete());

        $this->assertSame($input, $input->setAutocomplete(null));
        $this->assertFalse($input->hasAutocomplete());
        $this->expectException(\Throwable::class);
        $this->assertEquals(null, $input->getAutocomplete());
    }

    /**
     * @test
     */
    public function testInputmodeAttribute()
    {
        $this->markTestIncomplete();
    }

    /**
     * @test
     */
    public function testListAttribute()
    {
        $this->markTestIncomplete();
    }

    /**
     * @test
     * @covers \Replum\Html\InputMinLengthMaxLengthPatternSizeAttributesTrait::getMaxlength()
     * @covers \Replum\Html\InputMinLengthMaxLengthPatternSizeAttributesTrait::hasMaxlength()
     * @covers \Replum\Html\InputMinLengthMaxLengthPatternSizeAttributesTrait::setMaxlength()
     */
    public function testMaxlengthAttribute()
    {
        $input = $this->factory();
        $value1 = 20;
        $value2 = 10;

        $this->assertFalse($input->hasMaxlength());

        $this->assertSame($input, $input->setMaxlength($value1));
        $this->assertTrue($input->hasMaxlength());
        $this->assertSame($value1, $input->getMaxlength());

        $this->assertSame($input, $input->setMaxlength($value2));
        $this->assertTrue($input->hasMaxlength());
        $this->assertSame($value2, $input->getMaxlength());

        $this->assertSame($input, $input->setMaxlength(null));
        $this->assertFalse($input->hasMaxlength());
        $this->expectException(\Throwable::class);
        $this->assertEquals(null, $input->getMaxlength());
    }

    /**
     * @test
     * @covers \Replum\Html\InputMinLengthMaxLengthPatternSizeAttributesTrait::getMinlength()
     * @covers \Replum\Html\InputMinLengthMaxLengthPatternSizeAttributesTrait::hasMinlength()
     * @covers \Replum\Html\InputMinLengthMaxLengthPatternSizeAttributesTrait::setMinlength()
     */
    public function testMinlengthAttribute()
    {
        $input = $this->factory();
        $value1 = 20;
        $value2 = 10;

        $this->assertFalse($input->hasMinlength());

        $this->assertSame($input, $input->setMinlength($value1));
        $this->assertTrue($input->hasMinlength());
        $this->assertSame($value1, $input->getMinlength());

        $this->assertSame($input, $input->setMinlength($value2));
        $this->assertTrue($input->hasMinlength());
        $this->assertSame($value2, $input->getMinlength());

        $this->assertSame($input, $input->setMinlength(null));
        $this->assertFalse($input->hasMinlength());
        $this->expectException(\Throwable::class);
        $this->assertEquals(null, $input->getMinlength());
    }

    /**
     * @test
     */
    public function testPatternAttribute()
    {
        $this->markTestIncomplete();
    }

    /**
     * @test
     * @covers \Replum\Html\InputPlaceholderAttributeTrait::getPlaceholder()
     * @covers \Replum\Html\InputPlaceholderAttributeTrait::hasPlaceholder()
     * @covers \Replum\Html\InputPlaceholderAttributeTrait::setPlaceholder()
     */
    public function testPlaceholderAttribute()
    {
        $input = $this->factory();
        $value1 = "A placeholder";
        $value2 = "Some other text";

        $this->assertFalse($input->hasPlaceholder());

        $this->assertSame($input, $input->setPlaceholder($value1));
        $this->assertTrue($input->hasPlaceholder());
        $this->assertSame($value1, $input->getPlaceholder());

        $this->assertSame($input, $input->setPlaceholder($value2));
        $this->assertTrue($input->hasPlaceholder());
        $this->assertSame($value2, $input->getPlaceholder());

        $this->assertSame($input, $input->setPlaceholder(null));
        $this->assertFalse($input->hasPlaceholder());
        $this->expectException(\Throwable::class);
        $this->assertEquals(null, $input->getPlaceholder());
    }

    /**
     * @test
     * @covers \Replum\Html\InputReadonlyAttributeTrait::getReadonly()
     * @covers \Replum\Html\InputReadonlyAttributeTrait::setReadonly()
     */
    public function testReadonlyAttribute()
    {
        $input = $this->factory();

        $this->assertFalse($input->getReadonly());

        $this->assertSame($input, $input->setReadonly(true));
        $this->assertTrue($input->getReadonly());

        $this->assertSame($input, $input->setReadonly(false));
        $this->assertFalse($input->getReadonly());

        $this->assertSame($input, $input->setReadonly(true));
        $this->assertTrue($input->getReadonly());

        $this->expectException(\Throwable::class);
        $this->assertSame($input, $input->setReadonly(null));
    }

    /**
     * @test
     * @covers \Replum\Html\InputRequiredAttributeTrait::getRequired()
     * @covers \Replum\Html\InputRequiredAttributeTrait::setRequired()
     */
    public function testRequiredAttribute()
    {
        $input = $this->factory();

        $this->assertFalse($input->getRequired());

        $this->assertSame($input, $input->setRequired(true));
        $this->assertTrue($input->getRequired());

        $this->assertSame($input, $input->setRequired(false));
        $this->assertFalse($input->getRequired());

        $this->assertSame($input, $input->setRequired(true));
        $this->assertTrue($input->getRequired());

        $this->expectException(\Throwable::class);
        $this->assertSame($input, $input->setRequired(null));
    }

    /**
     * @test
     * @covers \Replum\Html\InputMinLengthMaxLengthPatternSizeAttributesTrait::getSize()
     * @covers \Replum\Html\InputMinLengthMaxLengthPatternSizeAttributesTrait::hasSize()
     * @covers \Replum\Html\InputMinLengthMaxLengthPatternSizeAttributesTrait::setSize()
     */
    public function testSizeAttribute()
    {
        $input = $this->factory();
        $value1 = 20;
        $value2 = 10;

        $this->assertFalse($input->hasSize());

        $this->assertSame($input, $input->setSize($value1));
        $this->assertTrue($input->hasSize());
        $this->assertSame($value1, $input->getSize());

        $this->assertSame($input, $input->setSize($value2));
        $this->assertTrue($input->hasSize());
        $this->assertSame($value2, $input->getSize());

        $this->assertSame($input, $input->setSize(null));
        $this->assertFalse($input->hasSize());
        $this->expectException(\Throwable::class);
        $this->assertEquals(null, $input->getSize());
    }

    /**
     * @test
     * @covers \Replum\Html\HtmlElement::render()
     * @covers \Replum\Html\NumberInput::renderAttributes()
     */
    public function testRender()
    {
        $ref = [
            "autocomplete" => Input::AUTOCOMPLETE_ON,
            "maxlength"    => "20",
            "minlength"    => "10",
            "placeholder"  => "Stupid text",
            "readonly"     => true,
            "required"     => true,
            "size"         => "5",
            "type"         => TextInput::TYPE,
        ];

        $html = $this->factory()
            ->setAutocomplete($ref['autocomplete'])
            ->setMaxlength($ref['maxlength'])
            ->setMinlength($ref['minlength'])
            ->setPlaceholder($ref['placeholder'])
            ->setReadonly($ref['readonly'])
            ->setRequired($ref['required'])
            ->setSize($ref['size'])
            ->render();

        $parsed = \DOMDocument::loadHtml($html);
        $dom = $parsed->getElementsByTagName(NumberInput::TAG)[0];
        $attributes = [];

        foreach ($dom->attributes as $attribute) {
            $attributes[$attribute->name] = ($attribute->value == $attribute->name || $attribute->value === '' ? true : $attribute->value);
        }

        $this->assertEquals($ref, $attributes);
    }
}
