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
 * @link https://www.w3.org/TR/html5/forms.html#attr-input-readonly
 */
trait InputReadonlyAttributeTrait
{
    /**
     * @var bool
     * @link https://www.w3.org/TR/html5/forms.html#attr-input-readonly
     */
    private $readonly = false;

    /**
     * @link https://www.w3.org/TR/html5/forms.html#attr-input-readonly
     */
    final public function getReadonly() : bool
    {
        return $this->readonly;
    }

    /**
     * @return $this
     * @link https://www.w3.org/TR/html5/forms.html#attr-input-readonly
     */
    final public function setReadonly(bool $readonly) : self
    {
        if ($this->readonly !== $readonly) {
            $this->readonly = $readonly;
            $this->setChanged(true);
        }
        return $this;
    }


    final protected function renderInputReadonlyAttribute() : string
    {
        return Util::renderHtmlAttribute('readonly', $this->readonly);
    }
}
