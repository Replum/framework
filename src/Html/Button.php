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

use \Replum\WidgetContainerInterface;
use \Replum\WidgetContainerTrait;
use \Replum\WidgetHasClickEventInterface;
use \Replum\WidgetHasClickEventTrait;

/**
 * @author Dennis Birkholz <dennis@birkholz.org>
 */
class Button implements WidgetContainerInterface, FormElementInterface, WidgetHasClickEventInterface
{
    use WidgetContainerTrait,
        WidgetHasClickEventTrait,
        FormInputTrait {
        setType as public;
    }

    public function __toString()
    {
        return '<' . $this->getTag() . $this->renderAttributes() . '>' . $this->renderChildren() . '</button>' . PHP_EOL;
    }

    /**
     * {@inheritdoc}
     */
    protected function validTags()
    {
        return [ 'button'];
    }

    /**
     * {@inheritdoc}
     */
    protected function renderAttributes()
    {
        return $this->renderWidgetAttributes()
        . $this->renderFormInputAttributes()
        ;
    }
}
