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

use \Replum\PageInterface;
use \Replum\Util;
use \Replum\WidgetHasClickEventInterface;
use \Replum\WidgetHasClickEventTrait;

/**
 * The button element represents a button labeled by its contents.
 *
 * The element is a button.
 *
 * The type attribute controls the behavior of the button when it is activated. It is an enumerated attribute. The following table lists the keywords and states for the attribute — the keywords in the left column map to the states in the cell in the second column on the same row as the keyword.
 *
 * @author Dennis Birkholz <dennis@birkholz.org>
 * @link https://www.w3.org/TR/html5/forms.html#the-button-element
 */
final class Button extends HtmlElement implements FormElementInterface, WidgetHasClickEventInterface
{
    use FormElementTrait;
    use WidgetHasClickEventTrait;

    const TAG = 'button';

    const TYPE_SUBMIT = 'submit';
    const TYPE_RESET = 'reset';
    const TYPE_BUTTON = 'button';

    ######################################################################
    # autofocus attribute                                                #
    ######################################################################

    // from FormElementTrait

    ######################################################################
    # disabled attribute                                                 #
    ######################################################################

    // from FormElementTrait

    ######################################################################
    # form attribute                                                     #
    ######################################################################

    // from FormElementTrait

    ######################################################################
    # formaction, formenctype, formmethod, formnovalidate, formtarget    #
    # attributes                                                         #
    ######################################################################

    // missing

    ######################################################################
    # menu attribute                                                     #
    ######################################################################

    // missing

    ######################################################################
    # name attribute                                                     #
    ######################################################################

    // from FormElementTrait

    ######################################################################
    # type attribute                                                     #
    ######################################################################

    /**
     * @var string
     * @link https://www.w3.org/TR/html5/forms.html#attr-button-type
     */
    private $type;

    /**
     * @link https://www.w3.org/TR/html5/forms.html#attr-button-type
     */
    final public function getType() : string
    {
        return $this->type;
    }

    /**
     * @link https://www.w3.org/TR/html5/forms.html#attr-button-type
     */
    final public function hasType() : bool
    {
        return ($this->type !== null);
    }

    /**
     * @return static $this
     * @link https://www.w3.org/TR/html5/forms.html#attr-button-type
     */
    final public function setType(string $type = null) : self
    {
        if ($type !== null && $type !== self::TYPE_SUBMIT && $type !== self::TYPE_RESET && $type !== self::TYPE_BUTTON) {
            throw new \InvalidArgumentException('Invalid button type "' . $type . '", use one of ' . self::class . '::TYPE_BUTTON, ' . self::class . '::TYPE_RESET, ' . self::class . '::TYPE_SUBMIT');
        }

        if ($this->type !== $type) {
            $this->type = $type;
            $this->setChanged(true);
        }
        return $this;
    }

    ######################################################################
    # value attribute                                                    #
    ######################################################################

    // from FormElementTrait

    ######################################################################
    # rendering                                                          #
    ######################################################################

    /**
     * {@inheritdoc}
     */
    protected function renderAttributes() : string
    {
        return parent::renderAttributes()
            . $this->renderFormElementAttributes()
            . Util::renderHtmlAttribute('type', $this->type)
        ;
    }

    /**
     * Restrict valid ARIA roles
     */
    protected function validRoles() : array
    {
        return [
            'button', 'link', 'menuitem', 'menuitemcheckbox', 'menuitemradio', 'radio',
        ];
    }
}
