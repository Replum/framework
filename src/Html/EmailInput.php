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
 * @link https://www.w3.org/TR/html5/forms.html#e-mail-state-(type=email)
 */
final class EmailInput extends Input
{
    use AutocompleteAttributeTrait;
    use MinlengthMaxLengthAttributesTrait;
    use MultipleAttributeTrait;
    use PatternAttributeTrait;
    use PlaceholderAttributeTrait;
    use ReadonlyAttributeTrait;
    use RequiredAttributeTrait;
    use SizeAttributeTrait;

    const TYPE = 'email';

    protected function renderAttributes() : string
    {
        return parent::renderAttributes()
            . $this->renderAutocompleteAttribute()
            . $this->renderMinlengthMaxlengthAttributes()
            . $this->renderMultipleAttribute()
            . $this->renderPatternAttribute()
            . $this->renderPlaceholderAttribute()
            . $this->renderReadonlyAttribute()
            . $this->renderRequiredAttribute()
            . $this->renderSizeAttribute()
        ;
    }
}
