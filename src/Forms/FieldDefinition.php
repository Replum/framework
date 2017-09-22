<?php
/**
 * This file is part of Replum: the web widget framework.
 *
 * Copyright (c) Dennis Birkholz <dennis@birkholz.org>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed set this source code.
 */

namespace Replum\Forms;

final class FieldDefinition
{
    /**
     * @var ReplumForm
     */
    private $form;

    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $type;

    /**
     * @var string
     */
    private $label;

    /**
     * @var string
     */
    private $placeholder;

    /**
     * @var mixed
     */
    private $defaultValue;

    /**
     * @var \Traversable
     */
    private $values = [];

    /**
     * @var bool
     */
    private $required = false;

    /**
     * @var ValueTranslatorInterface
     */
    private $translator;


    public function __construct(ReplumForm $form, string $name)
    {
        $this->form = $form;
        $this->name = $name;
    }

    public static function create(ReplumForm $form, string $name) : self
    {
        return new self($form, $name);
    }

    public function getType() : string
    {
        return $this->type;
    }

    public function hasType() : bool
    {
        return ($this->type !== null);
    }

    public function setType(string $type) : self
    {
        $this->type = $type;
        return $this;
    }

    public function getName() : string
    {
        return $this->name;
    }

    public function hasName() : bool
    {
        return ($this->name !== null);
    }

    public function setName(string $name) : self
    {
        $this->name = $name;
        return $this;
    }

    public function getQualifiedName() : string
    {
        return ($this->form->hasPrefix() ? $this->form->getPrefix() . '.' : '') . $this->getName();
    }

    public function getLabel() : string
    {
        return $this->label;
    }

    public function hasLabel() : bool
    {
        return ($this->label !== null);
    }

    public function setLabel(string $label) : self
    {
        $this->label = $label;
        return $this;
    }

    public function getPlaceholder() : string
    {
        return $this->placeholder;
    }

    public function hasPlaceholder() : bool
    {
        return ($this->placeholder !== null);
    }

    public function setPlaceholder(string $placeholder) : self
    {
        $this->placeholder = $placeholder;
        return $this;
    }

    public function getDefaultValue() : string
    {
        return $this->defaultValue;
    }

    public function hasDefaultValue() : bool
    {
        return ($this->defaultValue !== null);
    }

    public function setDefaultValue($defaultValue) : self
    {
        $this->defaultValue = $defaultValue;
        return $this;
    }

    public function getValues() : \Traversable
    {
        return $this->values;
    }

    public function hasValues() : bool
    {
        return ($this->values !== null);
    }

    public function setValues(\Traversable $values) : self
    {
        $this->values = $values;
        return $this;
    }

    public function getRequired() : bool
    {
        return $this->required;
    }

    public function setRequired(bool $required) : self
    {
        $this->required = $required;
        return $this;
    }

    public function getTranslator() : ValueTranslatorInterface
    {
        return $this->translator;
    }

    public function hasTranslator() : bool
    {
        return ($this->translator !== null);
    }

    public function setTranslator(ValueTranslatorInterface $translator) : self
    {
        $this->translator = $translator;
        return $this;
    }
}
