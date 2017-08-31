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
 * @link https://www.w3.org/TR/html5/forms.html#file-upload-state-(type=file)
 */
final class FileInput extends Input
{
    use InputMultipleAttributeTrait;
    use InputRequiredAttributeTrait;

    const TYPE = 'file';

    /**
     * @var string
     * @link https://www.w3.org/TR/html5/forms.html#attr-input-accept
     */
    private $accept;

    /**
     * @link https://www.w3.org/TR/html5/forms.html#attr-input-accept
     */
    final public function getAccept() : string
    {
        return $this->accept;
    }

    /**
     * @return boolean
     * @link https://www.w3.org/TR/html5/forms.html#attr-input-accept
     */
    final public function hasAccept() : bool
    {
        return ($this->accept !== null);
    }


    /**
     * @link https://www.w3.org/TR/html5/forms.html#attr-input-accept
     */
    final public function setAccept(string $accept = null) : self
    {
        if ($this->accept !== $accept) {
            $this->accept = $accept;
            $this->setChanged(true);
        }

        return $this;
    }

    protected function renderAttributes() : stzring
    {
        return parent::renderAttributes()
            . Util::renderHtmlAttribute('accept', $this->accept)
            . $this->renderInputMultipleAttribute()
            . $this->renderInputRequiredAttribute()
        ;
    }
}
