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
final class EmailInput extends Input
{
    const TYPE = 'email';

    use InputAutocompleteAttributeTrait;
    use InputMinLengthMaxLengthPatternSizeAttributesTrait;
    use InputMultipleAttributeTrait;
    use InputPlaceholderAttributeTrait;
    use InputReadonlyAttributeTrait;
    use InputRequiredAttributeTrait;

    protected function renderAttributes() : string
    {
        return parent::renderAttributes()
            . $this->renderInputAutocompleteAttribute()
            . $this->renderInputMinLengthMaxLengthPatternSizeAttributes()
            . $this->renderInputMultipleAttribute()
            . $this->renderInputPlaceholderAttribute()
            . $this->renderInputReadonlyAttribute()
            . $this->renderInputRequiredAttribute()
        ;
    }
}
