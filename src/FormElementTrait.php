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

/**
 * @author Dennis Birkholz <dennis@birkholz.org>
 * @property-read Form $form Formular containing this button (if any)
 */
trait FormElementTrait
{
    /**
     * @var Form
     */
    private $FormElementTraitForm;

    /**
     * @implements FormElementInterface
     * {@inheritdoc}
     */
    public function getForm()
    {
        if ($this->FormElementTraitForm !== null) {
            return $this->FormElementTraitForm;
        }

        return $this->getNearestAncestor(Form::class);
    }

    /**
     * @implements FormElementInterface
     * {@inheritdoc}
     */
    public function setForm(Form $form)
    {
        $this->FormElementTraitForm = $form;
    }
}
