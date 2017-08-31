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
final class DateInput extends Input
{
    use AutocompleteAttributeTrait;
    use MinMaxStepAttributesTrait;
    use PlaceholderAttributeTrait;
    use ReadonlyAttributeTrait;
    use RequiredAttributeTrait;

    const TYPE = 'date';

    protected function renderAttributes() : string
    {
        return parent::renderAttributes()
            . $this->renderAutocompleteAttribute()
            . $this->renderMinMaxStepAttributes()
            . $this->renderPlaceholderAttribute()
            . $this->renderReadonlyAttribute()
            . $this->renderRequiredAttribute()
        ;
    }
}
