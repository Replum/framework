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

class CheckboxInputTest extends HtmlTestBase
{
    /**
     * @return CheckboxInput
     */
    protected function factory() : HtmlElement
    {
        return HtmlFactory::checkboxInput($this->page);
    }

    protected $attributes = [
        // Common attributes
        "autofocus"      => true,
        "disabled"       => true,
        "form"           => null,
        "name"           => ["foo", "bar"],
        "value"          => ["foo", "bar"],

        "checked"        => true,
        "required"       => true,
    ];

    protected $additionalAttributes = [
        "type"           => CheckboxInput::TYPE,
    ];
}
