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
use \Replum\WidgetInterface;
use \Replum\WidgetTrait;

/**
 * @author Dennis Birkholz <dennis@birkholz.org>
 * @link https://www.w3.org/TR/html5/infrastructure.html#text-0
 * @link https://www.w3.org/TR/dom/#interface-text
 */
final class Text implements WidgetInterface, PhrasingElementInterface
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
    public function getText() : string
    {
        return $this->text;
    }

    /**
     * @return $this
     */
    public function setText(string $newText) : self
    {
        if ($newText !== $this->text) {
            $this->text = $newText;
            $this->setChanged(true);
        }

        return $this;
    }

    /**
     * @see WidgetInterface::render()
     */
    public function render(): string
    {
        return Util::escapeHtml($this->text);
    }

    /**
     * Factory method
     */
    public static function create(PageInterface $page, string $text)
    {
        return (new self($page))->setText($text);
    }
}
