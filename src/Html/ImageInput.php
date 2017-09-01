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
use \Replum\Html\Attributes\HeightWidthAttributesTrait;
use \Replum\Html\Attributes\SrcAttributeTrait;
use \Replum\Util;

/**
 * @author Dennis Birkholz <dennis@birkholz.org>
 * @link
 */
final class ImageInput extends Input
{
    use AltAttributeTrait;
    use HeightWidthAttributesTrait;
    use SrcAttributeTrait;

    const TYPE = 'image';

    protected function renderAttributes() : string
    {
        return parent::renderAttributes()
            . $this->renderAltAttribute()
            . $this->renderHeightWidthAttributes()
            . $this->renderSrcAttribute()
            . Util::renderHtmlAttribute('alt', $this->alt)
        ;
    }
}
