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

/**
 * @author Dennis Birkholz <dennis@birkholz.org>
 */
final class TextInput extends Input
{
    use InputAutocompleteAttributeTrait;
    use InputMinLengthMaxLengthPatternSizeAttributesTrait;

    const TYPE = 'text';

    protected function renderAttributes() : string
    {
        return parent::renderAttributes()
            . $this->renderInputAutocompleteAttribute()
            . $this->renderInputMinLengthMaxLengthPatternSizeAttributes()
        ;
    }
}
