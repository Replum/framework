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
        "value"          => ["foo", "bar"],

        "autocomplete"   => [Input::AUTOCOMPLETE_ON, Input::AUTOCOMPLETE_OFF],
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
}
