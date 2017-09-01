<?php

/*
 * This file is part of Replum: the web widget framework.
 *
 * Copyright (c) Dennis Birkholz <dennis@birkholz.org>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Replum\Html;

use Replum\Html\Attributes\AltAttributeTrait;
use Replum\Html\Attributes\HeightWidthAttributesTrait;
use \Replum\Html\Attributes\SrcAttributeTrait;
use \Replum\Util;

/**
 * @author Dennis Birkholz <dennis@birkholz.org>
 * @link https://www.w3.org/TR/html5/embedded-content-0.html#the-img-element
 */
final class Img extends HtmlElement
{
    use AltAttributeTrait;
    use HeightWidthAttributesTrait;
    use SrcAttributeTrait;

    const TAG = 'img';
    const EMPTY_ELEMENT = true;

    protected function renderAttributes() : string
    {
        return parent::renderAttributes()
            . $this->renderAltAttribute()
            . $this->renderHeightWidthAttributes()
            . $this->renderSrcAttribute()
        ;
    }
}
