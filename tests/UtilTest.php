<?php
/**
 * This file is part of Replum: the web widget framework.
 *
 * Copyright (c) Dennis Birkholz <dennis@birkholz.org>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Replum;

use PHPUnit\Framework\TestCase;

class UtilTest extends TestCase
{
    public function testQuotesInAttribute()
    {
        $attributeName = 'class';
        $attributeValue = ' foo "bar" baz';
        $html = '<div ' . Util::renderHtmlAttribute($attributeName, $attributeValue) . '></div>';
        $parsed = \DOMDocument::loadHtml($html);
        $dom = $parsed->getElementsByTagName('div')[0];
        $attributes = [];

        foreach ($dom->attributes as $attribute) {
            $attributes[$attribute->name] = ($attribute->value == $attribute->name || $attribute->value === '' ? true : $attribute->value);
        }

        $this->assertSame($attributeValue, $attributes[$attributeName]);
    }
}