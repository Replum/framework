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

class NumberInputTest extends TestCase
{
    private $page;

    public function setUp()
    {
        $this->page = new PageMock(new Context());
    }

    private function factory() : NumberInput
    {
        return HtmlFactory::numberInput($this->page);
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
    public function testListAttribute()
    {
        $this->markTestIncomplete();
    }

    /**
     * @test
     * @covers \Replum\Html\InputMinMaxStepAttributesTrait::getMax()
     * @covers \Replum\Html\InputMinMaxStepAttributesTrait::hasMax()
     * @covers \Replum\Html\InputMinMaxStepAttributesTrait::setMax()
     */
    public function testMaxAttribute()
    {
        $input = $this->factory();
        $value1 = 20.0;
        $value2 = 10.5;

        $this->assertFalse($input->hasMax());

        $this->assertSame($input, $input->setMax($value1));
        $this->assertTrue($input->hasMax());
        $this->assertSame($value1, $input->getMax());

        $this->assertSame($input, $input->setMax($value2));
        $this->assertTrue($input->hasMax());
        $this->assertSame($value2, $input->getMax());

        $this->assertSame($input, $input->setMax(null));
        $this->assertFalse($input->hasMax());
        $this->expectException(\Throwable::class);
        $this->assertEquals(null, $input->getMax());
    }

    /**
     * @test
     * @covers \Replum\Html\InputMinMaxStepAttributesTrait::getMin()
     * @covers \Replum\Html\InputMinMaxStepAttributesTrait::hasMin()
     * @covers \Replum\Html\InputMinMaxStepAttributesTrait::setMin()
     */
    public function testMinAttribute()
    {
        $input = $this->factory();
        $value1 = 20.0;
        $value2 = 10.5;

        $this->assertFalse($input->hasMin());

        $this->assertSame($input, $input->setMin($value1));
        $this->assertTrue($input->hasMin());
        $this->assertSame($value1, $input->getMin());

        $this->assertSame($input, $input->setMin($value2));
        $this->assertTrue($input->hasMin());
        $this->assertSame($value2, $input->getMin());

        $this->assertSame($input, $input->setMin(null));
        $this->assertFalse($input->hasMin());
        $this->expectException(\Throwable::class);
        $this->assertEquals(null, $input->getMin());
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
     * @covers \Replum\Html\InputMinMaxStepAttributesTrait::getStep()
     * @covers \Replum\Html\InputMinMaxStepAttributesTrait::hasStep()
     * @covers \Replum\Html\InputMinMaxStepAttributesTrait::setStep()
     */
    public function testStepAttribute()
    {
        $input = $this->factory();
        $value1 = 20.0;
        $value2 = 10.5;

        $this->assertFalse($input->hasStep());

        $this->assertSame($input, $input->setStep($value1));
        $this->assertTrue($input->hasStep());
        $this->assertSame($value1, $input->getStep());

        $this->assertSame($input, $input->setStep($value2));
        $this->assertTrue($input->hasStep());
        $this->assertSame($value2, $input->getStep());

        $this->assertSame($input, $input->setStep(null));
        $this->assertFalse($input->hasStep());
        $this->expectException(\Throwable::class);
        $this->assertEquals(null, $input->getStep());
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
            "max"          => "20",
            "min"          => "10",
            "placeholder"  => "Stupid text",
            "readonly"     => true,
            "required"     => true,
            "step"         => "5",
            "type"         => NumberInput::TYPE,
        ];

        $html = $this->factory()
            ->setAutocomplete($ref['autocomplete'])
            ->setMax($ref['max'])
            ->setMin($ref['min'])
            ->setPlaceholder($ref['placeholder'])
            ->setReadonly($ref['readonly'])
            ->setRequired($ref['required'])
            ->setStep($ref['step'])
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
