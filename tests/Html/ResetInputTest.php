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

class ResetInputTest extends HtmlTestBase
{
    /**
     * @return ResetInput
     */
    protected function factory() : HtmlElement
    {
        return HtmlFactory::resetInput($this->page);
    }

    protected $attributes = [
        // Common attributes
        "autofocus"      => true,
        "disabled"       => true,
        "form"           => null,
        "name"           => ["foo", "bar"],
        "value"          => ["foo", "bar"],
    ];

    protected $additionalAttributes = [
        "type"           => ResetInput::TYPE,
    ];
}

