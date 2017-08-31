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

class NumberInputTest extends HtmlTestBase
{
    /**
     * @return NumberInput
     */
    protected function factory() : HtmlElement
    {
        return HtmlFactory::numberInput($this->page);
    }

    protected $attributes = [
        // Common attributes
        "autofocus"      => true,
        "disabled"       => true,
        "form"           => null,
        "name"           => ["foo", "bar"],
        "value"          => ["foo", "bar"],

        "autocomplete"   => [Form::AUTOCOMPLETE_ON, Form::AUTOCOMPLETE_OFF],
        "list"           => null,
        "max"            => [20, 10],
        "min"            => [10, 20],
        "placeholder"    => ["placeholder I am", "Stupid text"],
        "readonly"       => true,
        "required"       => true,
        "step"           => [5, 10],
    ];

    protected $additionalAttributes = [
        "type"           => NumberInput::TYPE,
    ];
}
