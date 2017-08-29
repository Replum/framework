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
    const TAG = 'button';

    use FormElementTrait;
    use WidgetHasClickEventTrait;

    /**
     * {@inheritdoc}
     */
    protected function renderAttributes() : string
    {
        return parent::renderAttributes()
            . $this->renderFormElementAttributes()
        ;
    }

    public static function create(PageInterface $page) : self
    {
        return new self($page);
    }
}
