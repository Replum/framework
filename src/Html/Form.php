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

use Replum\Util;
use \Replum\WidgetContainer;
use \Replum\WidgetCollection;
use \Replum\WidgetInterface;
use \Replum\WidgetHasSubmitEventInterface;
use \Replum\WidgetHasSubmitEventTrait;

/**
 * @author Dennis Birkholz <dennis@birkholz.org>
 * @link https://www.w3.org/TR/html5/forms.html#the-form-element
 */
final class Form extends HtmlElement implements WidgetHasSubmitEventInterface
{
    use WidgetHasSubmitEventTrait;
    use AutocompleteAttributeTrait;

    const TAG = 'form';

    const AUTOCOMPLETE_ON = 'on';
    const AUTOCOMPLETE_OFF = 'off';

    const ENCTYPE_PLAIN = 'text/plain';
    const ENCTYPE_URLENCODED = 'application/x-www-form-urlencoded';
    const ENCTYPE_MULTIPART = 'multipart/form-data';

    const METHOD_GET = 'get';
    const METHOD_POST = 'post';

    ######################################################################
    # accept-charset attribute                                           #
    ######################################################################

    /**
     * Character encodings to use for form submission
     *
     * @var string
     * @link https://www.w3.org/TR/html5/forms.html#attr-form-accept-charset
     */
    private $acceptCharset;

    /**
     * Get the character encodings to use for form submission
     *
     * @link https://www.w3.org/TR/html5/forms.html#attr-form-accept-charset
     */
    final public function getAcceptCharset() : string
    {
        return $this->acceptCharset;
    }

    /**
     * Check whether the character encodings to use for form submission is set
     *
     * @link https://www.w3.org/TR/html5/forms.html#attr-form-accept-charset
     */
    final public function hasAcceptCharset() : bool
    {
        return ($this->acceptCharset !== null);
    }

    /**
     * Set the character encodings to use for form submission
     *
     * @link https://www.w3.org/TR/html5/forms.html#attr-form-accept-charset
     */
    final public function setAcceptCharset(string $acceptCharset = null) : self
    {
        if ($this->acceptCharset !== $acceptCharset) {
            $this->acceptCharset = $acceptCharset;
            $this->setChanged(true);
        }
        return $this;
    }

    ######################################################################
    # action attribute                                                   #
    ######################################################################

    /**
     * URL to use for form submission
     *
     * @var string
     * @link https://www.w3.org/TR/html5/forms.html#attr-fs-action
     */
    private $action;

    /**
     * Get the URL to use for form submission
     *
     * @link https://www.w3.org/TR/html5/forms.html#attr-fs-action
     */
    final public function getAction() : string
    {
        return $this->action;
    }

    /**
     * Check whether the URL to use for form submission is set
     *
     * @link https://www.w3.org/TR/html5/forms.html#attr-fs-action
     */
    final public function hasAction() : bool
    {
        return ($this->action !== null);
    }

    /**
     * Set the URL to use for form submission
     *
     * @link https://www.w3.org/TR/html5/forms.html#attr-fs-action
     */
    final public function setAction(string $action = null) : self
    {
        if ($this->action !== $action) {
            $this->action = $action;
            $this->setChanged(true);
        }
        return $this;
    }

    ######################################################################
    # enctype attribute                                                  #
    ######################################################################

    /**
     * Form data set encoding type to use for form submission
     *
     * @var string
     * @link https://www.w3.org/TR/html5/forms.html#attr-fs-enctype
     */
    private $enctype;

    /**
     * Get the form data set encoding type to use for form submission
     *
     * @link https://www.w3.org/TR/html5/forms.html#attr-fs-enctype
     */
    final public function getEnctype() : string
    {
        return $this->enctype;
    }

    /**
     * Check whether the form data set encoding type to use for form submission is set
     *
     * @link https://www.w3.org/TR/html5/forms.html#attr-fs-enctype
     */
    final public function hasEnctype() : bool
    {
        return ($this->enctype !== null);
    }

    /**
     * Set the form data set encoding type to use for form submission
     *
     * @link https://www.w3.org/TR/html5/forms.html#attr-fs-enctype
     */
    final public function setEnctype(string $enctype = null) : self
    {
        if ($enctype !== null && $enctype !== self::ENCTYPE_PLAIN && $enctype !== self::ENCTYPE_URLENCODED && $enctype !== self::ENCTYPE_MULTIPART) {
            throw new \InvalidArgumentException('Invalid enctype!');
        }

        if ($this->enctype !== $enctype) {
            $this->enctype = $enctype;
            $this->setChanged(true);
        }
        return $this;
    }

    ######################################################################
    # method attribute                                                   #
    ######################################################################

    /**
     * HTTP method to use for form submission
     *
     * @var string
     * @link https://www.w3.org/TR/html5/forms.html#attr-fs-method
     */
    private $method;

    /**
     * Get the HTTP method to use for form submission
     *
     * @link https://www.w3.org/TR/html5/forms.html#attr-fs-method
     */
    final public function getMethod() : string
    {
        return $this->method;
    }

    /**
     * Check whether the HTTP method to use for form submission is set
     *
     * @link https://www.w3.org/TR/html5/forms.html#attr-fs-method
     */
    final public function hasMethod() : bool
    {
        return ($this->method !== null);
    }

    /**
     * Set the HTTP method to use for form submission
     *
     * @link https://www.w3.org/TR/html5/forms.html#attr-fs-method
     */
    final public function setMethod(string $method = null) : self
    {
        if ($method !== null && $method !== self::METHOD_GET && $method !== self::METHOD_POST) {
            throw new \InvalidArgumentException('Invalid method!');
        }

        if ($this->method !== $method) {
            $this->method = $method;
            $this->setChanged(true);
        }
        return $this;
    }

    ######################################################################
    # name attribute                                                     #
    ######################################################################

    /**
     * Name of form to use in the document.forms API
     *
     * @var string
     * @link https://www.w3.org/TR/html5/forms.html#attr-form-name
     */
    private $name;

    /**
     * Get the name of form to use in the document.forms API
     *
     * @link https://www.w3.org/TR/html5/forms.html#attr-form-name
     */
    final public function getName() : string
    {
        return $this->name;
    }

    /**
     * Check whether the name of form to use in the document.forms API is set
     *
     * @link https://www.w3.org/TR/html5/forms.html#attr-form-name
     */
    final public function hasName() : bool
    {
        return ($this->name !== null);
    }

    /**
     * Set the name of form to use in the document.forms API
     *
     * @link https://www.w3.org/TR/html5/forms.html#attr-form-name
     */
    final public function setName(string $name = null) : self
    {
        if ($this->name !== $name) {
            $this->name = $name;
            $this->setChanged(true);
        }
        return $this;
    }

    ######################################################################
    # novalidate attribute                                               #
    ######################################################################

    /**
     * Bypass form control validation for form submission
     *
     * @var bool
     * @link https://www.w3.org/TR/html5/forms.html#attr-fs-novalidate
     */
    private $novalidate = false;

    /**
     * Check whether to bypass form control validation for form submission
     *
     * @link https://www.w3.org/TR/html5/forms.html#attr-fs-novalidate
     */
    final public function getNovalidate() : bool
    {
        return $this->novalidate;
    }

    /**
     * Set whether to bypass form control validation for form submission
     *
     * @return static $this
     * @link https://www.w3.org/TR/html5/forms.html#attr-fs-novalidate
     */
    final public function setNovalidate(bool $novalidate) : self
    {
        if ($this->novalidate !== $novalidate) {
            $this->novalidate = $novalidate;
            $this->setChanged(true);
        }
        return $this;
    }

    ######################################################################
    # target attribute                                                   #
    ######################################################################


    /**
     * Browsing context for form submission
     *
     * @var string
     * @link https://www.w3.org/TR/html5/forms.html#attr-fs-target
     */
    private $target;

    /**
     * Get the browsing context for form submission
     *
     * @link https://www.w3.org/TR/html5/forms.html#attr-fs-target
     */
    final public function getTarget() : string
    {
        return $this->target;
    }

    /**
     * Check whether the browsing context for form submission is set
     *
     * @link https://www.w3.org/TR/html5/forms.html#attr-fs-target
     */
    final public function hasTarget() : bool
    {
        return ($this->target !== null);
    }

    /**
     * Set the browsing context for form submission
     *
     * @link https://www.w3.org/TR/html5/forms.html#attr-fs-target
     */
    final public function setTarget(string $target = null) : self
    {
        if ($this->target !== $target) {
            $this->target = $target;
            $this->setChanged(true);
        }
        return $this;
    }

    ######################################################################
    # Rendering                                                          #
    ######################################################################

    protected function renderAttributes() : string
    {
        return parent::renderAttributes()
            . Util::renderHtmlAttribute('accept-charset', $this->acceptCharset)
            . Util::renderHtmlAttribute('action', $this->action)
            . $this->renderAutocompleteAttribute()
            . Util::renderHtmlAttribute('enctype', $this->enctype)
            . Util::renderHtmlAttribute('method', $this->method)
            . Util::renderHtmlAttribute('name', $this->name)
            . Util::renderHtmlAttribute('novalidate', $this->novalidate)
            . Util::renderHtmlAttribute('target', $this->target)
        ;
    }

}
