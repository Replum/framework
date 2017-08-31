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

class FormTest extends HtmlTestBase
{
    /**
     * @return Form
     */
    protected function factory() : HtmlElement
    {
        return HtmlFactory::form($this->page);
    }

    protected $attributes = [
        "accept-charset" => ['latin1', 'utf8'],
        "action"         => ['/index.php', '/formsubmit.php'],
        "autocomplete"   => [Form::AUTOCOMPLETE_ON, Form::AUTOCOMPLETE_OFF],
        "enctype"        => [Form::ENCTYPE_PLAIN, Form::ENCTYPE_URLENCODED, Form::ENCTYPE_MULTIPART],
        "method"         => [Form::METHOD_GET, Form::METHOD_POST],
        "name"           => ["foo", "bar"],
        "novalidate"     => true,
        "target"         => ['_blank', 'anotherWindow'],
    ];

}
