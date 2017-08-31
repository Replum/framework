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
 */
final class NumberInput extends Input
{
    use InputAutocompleteAttributeTrait;
    use InputMinMaxStepAttributeTrait;
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

    public function setValue($newValue)
    {
        if (is_null($newValue) || ($newValue === '')) {
            return $this->originalSetValue(null);
        }

        if (!is_numeric($newValue)) {
            throw new \InvalidArgumentException('Invalid number 1');
        }

        if (!is_null($this->min) && ($newValue < $this->min)) {
            throw new \InvalidArgumentException('Invalid number 2');
        }

        if (!is_null($this->max) && ($this->max < $newValue)) {
            throw new \InvalidArgumentException('Invalid number 3');
        }

        if (!is_null($this->min) && !is_null($this->step) && is_int($this->step)) {
            $matchesStep = ($newValue - $this->min) % $this->step;

            if ($matchesStep) {
                throw new \InvalidArgumentException('Invalid number 4: ' . $matchesStep);
            }
        }

        return $this->originalSetValue($newValue);
    }
}
