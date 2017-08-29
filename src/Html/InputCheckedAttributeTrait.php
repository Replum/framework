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

trait InputCheckedAttributeTrait
{
    /**
     * @var bool
     * @link http://www.w3.org/TR/html5/forms.html#attr-input-checked
     */
    private $checked = false;

    /**
     * @link http://www.w3.org/TR/html5/forms.html#attr-input-checked
     */
    final public function getChecked() : bool
    {
        return $this->checked;
    }

    /**
     * @link http://www.w3.org/TR/html5/forms.html#attr-input-checked
     */
    final public function setChecked(bool $checked) : self
    {
        if ($this->checked !== $checked) {
            $this->checked = $checked;
            $this->setChanged(true);
        }

        return $this;
    }

    final protected function renderInputCheckedAttribute() : string
    {
        return Util::renderHtmlAttribute('checked', $this->checked);
    }
}
