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
final class PasswordInput extends Input
{
    const TYPE = 'password';

    use InputAutocompleteAttributeTrait;
    use InputMinLengthMaxLengthPatternSizeAttributesTrait;
    use InputPlaceholderAttributeTrait;
    use InputReadonlyAttributeTrait;
    use InputRequiredAttributeTrait;

    protected function renderAttributes() : string
    {
        return parent::renderAttributes()
            . $this->renderInputAutocompleteAttribute()
            . $this->renderInputMinLengthMaxLengthPatternSizeAttributes()
            . $this->renderInputPlaceholderAttribute()
            . $this->renderInputReadonlyAttribute()
            . $this->renderInputRequiredAttribute()
        ;
    }
}
