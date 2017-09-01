<?php

/**
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
 * @link https://www.w3.org/TR/html5/forms.html#the-textarea-element
 */
final class Textarea extends HtmlElement implements FormInputInterface
{
    use FormElementTrait;
    use AutocompleteAttributeTrait;
    use MinlengthMaxLengthAttributesTrait;
    use PlaceholderAttributeTrait;
    use ReadonlyAttributeTrait;
    use RequiredAttributeTrait;

    const TAG = 'textarea';

    const WRAP_SOFT = 'soft';
    const WRAP_HARD = 'hard';

    /**
     * Maximum number of characters per line
     *
     * @var int
     * @link https://www.w3.org/TR/html5/forms.html#attr-textarea-cols
     */
    private $cols;

    /**
     * @link https://www.w3.org/TR/html5/forms.html#attr-textarea-cols
     */
    final public function getCols() : int
    {
        return $this->cols;
    }

    /**
     * @link https://www.w3.org/TR/html5/forms.html#attr-textarea-cols
     */
    final public function hasCols() : bool
    {
        return ($this->cols !== null);
    }

    /**
     * @return static $this
     * @link https://www.w3.org/TR/html5/forms.html#attr-textarea-cols
     */
    final public function setCols(int $cols = null) : self
    {
        if ($this->cols !== $cols) {
            $this->cols = $cols;
            $this->setChanged(true);
        }
        return $this;
    }

    /**
     * Number of lines to show
     *
     * @var int
     * @link https://www.w3.org/TR/html5/forms.html#attr-textarea-rows
     */
    private $rows;

    /**
     * Get the number of lines to show
     *
     * @link https://www.w3.org/TR/html5/forms.html#attr-textarea-rows
     */
    final public function getRows() : int
    {
        return $this->rows;
    }

    /**
     * Check whether the number of lines to show is set
     *
     * @link https://www.w3.org/TR/html5/forms.html#attr-textarea-rows
     */
    final public function hasRows() : bool
    {
        return ($this->rows !== null);
    }

    /**
     * Set the number of lines to show
     *
     * @return static $this
     * @link https://www.w3.org/TR/html5/forms.html#attr-textarea-rows
     */
    final public function setRows(int $rows = null) : self
    {
        if ($this->rows !== $rows) {
            $this->rows  = $rows;
            $this->setChanged(true);
        }
        return $this;
    }

    /**
     * How the value of the form control is to be wrapped for form submission
     *
     * @var WRAP_SOFT|WRAP_HARD
     * @link https://www.w3.org/TR/html5/forms.html#attr-textarea-wrap
     */
    private $wrap;

    /**
     * Get how the value of the form control is to be wrapped for form submission
     *
     * @link https://www.w3.org/TR/html5/forms.html#attr-textarea-wrap
     */
    final public function getWrap() : string
    {
        return $this->wrap;
    }

    /**
     * Check whether how the value of the form control is to be wrapped for form submission is set
     *
     * @link https://www.w3.org/TR/html5/forms.html#attr-textarea-wrap
     */
    final public function hasWrap() : bool
    {
        return ($this->wrap !== null);
    }

    /**
     * Set how the value of the form control is to be wrapped for form submission
     *
     * @return static $this
     * @link https://www.w3.org/TR/html5/forms.html#attr-textarea-wrap
     */
    final public function setWrap(string $wrap = null) : self
    {
        if ($wrap !== Textarea::WRAP_SOFT && $wrap !== Textarea::WRAP_HARD && $wrap !== null) {
            throw new \InvalidArgumentException('Valid values for wrap are: ' . Textarea::class . '::WRAP_SOFT, ' . Textarea::class . '::WRAP_HARD and NULL!');
        }

        if ($this->wrap !== $wrap) {
            $this->wrap = $wrap;
            $this->setChanged(true);
        }

        return $this;
    }

    protected function renderAttributes() : string
    {
        return parent::renderAttributes()
            . $this->renderFormElementAttributes(false)
            . $this->renderAutocompleteAttribute()
            . $this->renderMinlengthMaxlengthAttributes()
            . $this->renderPlaceholderAttribute()
            . $this->renderReadonlyAttribute()
            . $this->renderRequiredAttribute()
            . Util::renderHtmlAttribute('cols', $this->cols)
            . Util::renderHtmlAttribute('rows', $this->rows)
            . Util::renderHtmlAttribute('wrap', $this->wrap)
        ;
    }

    public function render(): string
    {
        return '<' . self::TAG . $this->renderAttributes() . '>'
            . ($this->hasValue() ? Util::escapeHtml($this->getValue()) : null)
            . '</' . self::TAG . '>' . PHP_EOL
        ;
    }
}
