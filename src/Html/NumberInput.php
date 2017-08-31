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

use \Replum\Util;

/**
 * @author Dennis Birkholz <dennis@birkholz.org>
 * @link https://www.w3.org/TR/html5/forms.html#number-state-(type=number)
 */
final class NumberInput extends Input
{
    use InputAutocompleteAttributeTrait;
    use InputMinMaxStepAttributesTrait;
    use InputPlaceholderAttributeTrait;
    use InputReadonlyAttributeTrait;
    use InputRequiredAttributeTrait;

    const TYPE = 'number';

    protected function renderAttributes() : string
    {
        return parent::renderAttributes()
            . $this->renderInputAutocompleteAttribute()
            . $this->renderInputMinMaxStepAttributes()
            . $this->renderInputPlaceholderAttribute()
            . $this->renderInputReadonlyAttribute()
            . $this->renderInputRequiredAttribute()
        ;
    }
}
