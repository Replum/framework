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

trait AutocompleteAttributeTrait
{
    /**
     * @var AUTOCOMPLETE_ON|AUTOCOMPLETE_OFF
     * @link http://www.w3.org/TR/html5/forms.html#attr-fe-autocomplete
     */
    private $autocomplete;

    /**
     * @link http://www.w3.org/TR/html5/forms.html#attr-fe-autocomplete
     */
    final public function getAutocomplete() : string
    {
        return $this->autocomplete;
    }

    /**
     * @return boolean
     * @link http://www.w3.org/TR/html5/forms.html#attr-fe-autocomplete
     */
    final public function hasAutocomplete() : bool
    {
        return ($this->autocomplete !== null);
    }

    /**
     * @return static $this
     * @link http://www.w3.org/TR/html5/forms.html#attr-fe-autocomplete
     */
    final public function setAutocomplete(string $autocomplete = null) : self
    {
        if ($autocomplete !== Form::AUTOCOMPLETE_ON && $autocomplete !== Form::AUTOCOMPLETE_OFF && $autocomplete !== null) {
            throw new \InvalidArgumentException('Valid values for autocomplete are: ' . Input::class . '::AUTOCOMPLETE_ON, ' . Input::class . '::AUTOCOMPLETE_OFF and NULL!');
        }

        if ($this->autocomplete !== $autocomplete) {
            $this->autocomplete = $autocomplete;
            $this->setChanged(true);
        }

        return $this;
    }

    final protected function renderAutocompleteAttribute() : string
    {
        return Util::renderHtmlAttribute('autocomplete', $this->autocomplete);
    }
}
