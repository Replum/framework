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

use \Replum\WidgetInterface;

/**
 * @author Dennis Birkholz <dennis@birkholz.org>
 */
interface FormElementInterface extends WidgetInterface
{
    /**
     * Get the form this FormElement is associated with
     *
     * @return Form
     */
    function getForm();

    /**
     * Set the form for the FormElement
     * Should only be used by handlers that manage form association,
     *
     * @param Form $form
     * @return FormElementInterface $this for chaining
     */
    function setForm(Form $form);
}
