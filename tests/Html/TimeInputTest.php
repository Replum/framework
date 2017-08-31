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

class TimeInputTest extends HtmlTestBase
{
    /**
     * @return TimeInput
     */
    protected function factory() : HtmlElement
    {
        return HtmlFactory::timeInput($this->page);
    }

    protected $attributes = [
        "autofocus"      => true,
        "name"           => ["foo", "bar"],
        "value"          => ["foo", "bar"],

        "autocomplete"   => [Input::AUTOCOMPLETE_ON, Input::AUTOCOMPLETE_OFF],
        "list"           => null,
        "max"            => [20, 10],
        "min"            => [10, 20],
        "placeholder"    => ["placeholder I am", "Stupid text"],
        "readonly"       => true,
        "required"       => true,
        "step"           => [5, 10],
    ];

    protected $additionalAttributes = [
        "type"           => TimeInput::TYPE,
    ];
}
