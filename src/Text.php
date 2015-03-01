<?php

/*
 * This file is part of the nexxes/widgets-html package.
 *
 * Copyright (c) Dennis Birkholz, nexxes Informationstechnik GmbH <dennis.birkholz@nexxes.net>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace nexxes\widgets\html;

use \nexxes\widgets\WidgetInterface;
use \nexxes\widgets\WidgetTrait;

/**
 * @author Dennis Birkholz <dennis.birkholz@nexxes.net>
 */
class Text implements WidgetInterface, PhrasingContentInterface
{
    use WidgetTrait;

    /**
     * The text value of this Text widget
     *
     * @var string
     */
    private $text = '';

    /**
     * @return string
     */
    public function getText()
    {
        return $this->text;
    }

    /**
     * @param type $newText
     * @return \nexxes\widgets\html\Text $this for chaining
     */
    public function setText($newText)
    {
        if (!is_string($newText)) {
            throw new \InvalidArgumentException('Supplied text value must be a string.');
        }

        if ($newText !== $this->text) {
            $this->text = $newText;
            $this->setChanged(true);
        }

        return $this;
    }

    /**
     * The tag this text is rendered with.
     * If the type is not explicitly set and not attribute needs rendering, no tag is rendered.
     * If the type is set, a tag will render regarless of the attribute values.
     * If the attribute values require a tag to be rendered, '<span>' is used if no type is specified.
     *
     * @var string
     */
    private $tag;

    /**
     * @return string
     */
    public function getTag()
    {
        return $this->tag;
    }

    /**
     * @param string $newTag The tag type to set
     * @return \nexxes\widgets\html\Text $this for chaining
     */
    public function setTag($newTag)
    {
        if (!in_array($newTag, $this->validTags())) {
            throw new \InvalidArgumentException('Invalid type "' . $newTag . '" supplied! Allowed values are: "' . \implode('", "', $this->validTags()) . '"');
        }

        if ($newTag !== $this->tag) {
            $this->tag = $newTag;
            $this->setChanged(true);
        }

        return $this;
    }

    /**
     * @return array<string> The list of possible types to set via setType()
     */
    public function validTags()
    {
        return [ 'span', 'div', 'p', 'h1', 'h2', 'h3', 'h4', 'h5', 'h6', 'a', 'legend', 'b', 'i', 'strike'];
    }

    public function __construct(WidgetInterface $parent = null)
    {
        if ($parent !== null) { $this->setParent($parent); }
    }

    public function __toString()
    {
        $attributes = $this->renderAttributes();

        if (!is_null($this->tag) || ($attributes != '')) {
            return '<' . ($this->tag ? : 'span') . $attributes . '>' . $this->escape($this->text) . '</' . ($this->tag ? : 'span') . '>';
        } else {
            return \str_replace("\n", '<br />', $this->escape($this->text));
        }
    }

}
