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

class ImageInputTest extends HtmlTestBase
{
    /**
     * @return ImageInput
     */
    protected function factory() : HtmlElement
    {
        return HtmlFactory::imageInput($this->page);
    }

    protected $attributes = [
        // Common attributes
        "autofocus"      => true,
        "disabled"       => true,
        "form"           => null,
        "name"           => ["foo", "bar"],
        "value"          => ["foo", "bar"],

        "alt"            => ["alternative", "title"],
        //"formaction"     => ["foo", "bar"],
        "formaction"     => null,
        //"formenctype"    => ["foo", "bar"],
        "formenctype"    => null,
        //"formmethod"     => ["foo", "bar"],
        "formmethod"     => null,
        //"formnovalidate" => ["foo", "bar"],
        "formnovalidate" => null,
        //"formtarget"     => ["foo", "bar"],
        "formtarget"     => null,
        "height"         => [5, 10],
        "src"            => ["foo", "bar"],
        "width"          => [5, 10],
    ];

    protected $additionalAttributes = [
        "type"           => ImageInput::TYPE,
    ];
}
