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

use \Replum\Util;

/**
 * Implements interface WidgetInterface
 *
 * @author Dennis Birkholz <dennis@birkholz.org>
 */
trait WidgetTrait
{
    ######################################################################
    # Class attribute                                                    #
    ######################################################################

    /**
     * The list of classes this html widgets has
     *
     * @var array<string>
     * @see http://www.w3.org/TR/html5/dom.html#classes
     */
    private $htmlWidgetTraitClasses = [];

    /**
     *  @see \Replum\Html\WidgetInterface::addClass()
     */
    final public function addClass(string $newClass) : WidgetInterface
    {
        if (!\in_array($newClass, $this->htmlWidgetTraitClasses, true)) {
            $this->htmlWidgetTraitClasses[] = $newClass;
            $this->setChanged(true);
        }

        return $this;
    }

    /**
     * @see \Replum\Html\WidgetInterface::delClass()
     */
    final public function delClass(string $class, bool $isRegex = false) : WidgetInterface
    {
        // Regex matching
        if ($isRegex) {
            foreach ($this->htmlWidgetTraitClasses AS $index => $checkClass) {
                if (\preg_match($class, $checkClass)) {
                    unset($this->htmlWidgetTraitClasses[$index]);
                    $this->setChanged(true);
                }
            }
        }

        // Literal class name matching
        elseif (($key = \array_search($class, $this->htmlWidgetTraitClasses)) !== false) {
            unset($this->htmlWidgetTraitClasses[$key]);
            $this->setChanged(true);
        }

        return $this;
    }

    /**
     * @see \Replum\Html\WidgetInterface::hasClass()
     */
    final public function hasClass(string $class, bool $isRegex = false) : bool
    {
        // Regex matching
        if ($isRegex) {
            foreach ($this->htmlWidgetTraitClasses AS $checkClass) {
                if (\preg_match($class, $checkClass)) {
                    return true;
                }
            }

            return false;
        }

        // Literal class name matching
        else {
            return \in_array($class, $this->htmlWidgetTraitClasses);
        }
    }

    /**
     * @see \Replum\Html\WidgetInterface::getClasses()
     */
    final public function getClasses(bool $regex = null) : array
    {
        // Get only classes matching the supplied regex
        if (!is_null($regex)) {
            $found = [];
            foreach ($this->htmlWidgetTraitClasses AS $class) {
                if (\preg_match($regex, $class)) {
                    $found[] = $class;
                }
            }
            return $found;
        }

        // Get all classes
        else {
            return $this->htmlWidgetTraitClasses;
        }
    }

    ######################################################################
    # Id attribute                                                       #
    ######################################################################

    /**
     * This widget requires that the ID attribute is rendered
     *
     * @var bool
     */
    private $htmlWidgetTraitRequiresId = false;

    /**
     * @see \Replum\Html\WidgetInterface::hasID()
     */
    final public function hasID() : bool
    {
        return $this->htmlWidgetTraitRequiresId;
    }

    /**
     * @see \Replum\Html\WidgetInterface::getID()
     */
    final public function getID() : string
    {
        $this->needID();
        return $this->getWidgetId();
    }

    /**
     * @see \Replum\Html\WidgetInterface::setID()
     */
    final public function setID(string $newID) : WidgetInterface
    {
        // Ignore resettings same ID
        if ($this->getWidgetId() === $newID) {
            return $this;
        }

        $this->setWidgetId($newID);
        $this->needId();
        return $this;
    }

    /**
     * @see \Replum\Html\WidgetInterface::needID()
     */
    final public function needID() : WidgetInterface
    {
        $this->htmlWidgetTraitRequiresId = true;
        $this->setChanged(true);

        return $this;
    }

    ######################################################################
    # Style attribute                                                    #
    ######################################################################

    /**
     * @var string
     */
    private $htmlWidgetTraitStyle;

    /**
     * @see \Replum\Html\WidgetInterface::getStyle()
     */
    final public function getStyle() : string
    {
        return $this->htmlWidgetTraitStyle;
    }

    /**
     * @see \Replum\Html\WidgetInterface::hasStyle()
     */
    final public function hasStyle() : bool
    {
        return ($this->htmlWidgetTraitStyle !== null);
    }

    /**
     * @see \Replum\Html\WidgetInterface::setStyle()
     */
    final public function setStyle(string $newStyle = null) : WidgetInterface
    {
        if ($newStyle !== $this->htmlWidgetTraitStyle) {
            $this->htmlWidgetTraitStyle = $newStyle;
            $this->setChanged(true);
        }

        return $this;
    }

    ######################################################################
    # Tabindex attribute                                                 #
    ######################################################################

    /**
     * The tabindex content attribute allows authors to control whether an element is supposed to be focusable, whether it is supposed to be reachable using sequential focus navigation, and what is to be the relative order of the element for the purposes of sequential focus navigation. The name "tab index" comes from the common use of the "tab" key to navigate through the focusable elements. The term "tabbing" refers to moving forward through the focusable elements that can be reached using sequential focus navigation.
     *
     * @var int
     * @see http://www.w3.org/TR/html5/editing.html#attr-tabindex
     */
    private $htmlWidgetTraitTabindex;

    /**
     * @see \Replum\Html\WidgetInterface::getTabIndex()
     */
    final public function getTabIndex() : int
    {
        return $this->htmlWidgetTraitTabindex;
    }

    /**
     * @see \Replum\Html\WidgetInterface::hasTabIndex()
     */
    final public function hasTabIndex() : bool
    {
        return ($this->htmlWidgetTraitTabindex !== null);
    }

    /**
     * @see \Replum\WidgetInterface::setTabIndex()
     */
    final public function setTabIndex(int $newTabIndex = null) : WidgetInterface
    {
        if ($this->htmlWidgetTraitTabindex !== $newTabIndex) {
            $this->htmlWidgetTraitTabindex = $newTabIndex;
            $this->setChanged(true);
        }

        return $this;
    }

    ######################################################################
    # Title attribute                                                    #
    ######################################################################

    /**
     * The title attribute represents advisory information for the element, such as would be appropriate for a tooltip. On a link, this could be the title or a description of the target resource; on an image, it could be the image credit or a description of the image; on a paragraph, it could be a footnote or commentary on the text; on a citation, it could be further information about the source; on interactive content, it could be a label for, or instructions for, use of the element; and so forth. The value is text.
     *
     * @var string
     * @see http://www.w3.org/TR/html5/dom.html#attr-title
     */
    protected $htmlWidgetTraitTitle;

    /**
     * @see \Replum\Html\WidgetInterface::getTitle()
     */
    final public function getTitle() : string
    {
        return $this->htmlWidgetTraitTitle;
    }

    /**
     * @see \Replum\Html\WidgetInterface::hasTitle()
     */
    final public function hasTitle() : bool
    {
        return ($this->htmlWidgetTraitTitle !== null);
    }

    /**
     * @see \Replum\Html\WidgetInterface::setTitle()
     */
    final public function setTitle(string $newTitle = null) : WidgetInterface
    {
        if ($this->htmlWidgetTraitTitle !== $newTitle) {
            $this->htmlWidgetTraitTitle = $newTitle;
            $this->setChanged(true);
        }

        return $this;
    }

    ######################################################################
    # Custom data attributes                                             #
    ######################################################################

    /**
     * Custom data attributes
     *
     * @var array<string>
     * @link http://www.w3.org/TR/html5/dom.html#embedding-custom-non-visible-data-with-the-data-*-attributes
     */
    private $htmlWidgetTraitData = [];

    /**
     * @see \Replum\Html\WidgetInterface::addData()
     */
    final public function addData(string $name, string $value) : WidgetInterface
    {
        return $this->setData($name, ($this->hasData($name) ? $this->getData($name) . ' ' : '') . $value);
    }

    /**
     * @see \Replum\Html\WidgetInterface::getData()
     */
    final public function getData(string $name) : string
    {
        if (!$this->hasData($name)) {
            throw new \InvalidArgumentException("No data set for data attribute '$name'!");
        }

        return $this->htmlWidgetTraitData[$name];
    }

    /**
     * @see \Replum\Html\WidgetInterface::getDataset()
     */
    final public function getDataset() : array
    {
        return $this->htmlWidgetTraitData;
    }

    /**
     * @see \Replum\Html\WidgetInterface::hasData()
     */
    final public function hasData(string $name) : bool
    {
        return isset($this->htmlWidgetTraitData[$name]);
    }

    /**
     * @see \Replum\Html\WidgetInterface::setData()
     */
    final public function setData(string $name, string $newValue = null) : WidgetInterface
    {
        if (!\strlen($name)) {
            throw new \InvalidArgumentException('Data attribute requires a name!');
        }

        if (\strpos($name, ':') !== false) {
            throw new \InvalidArgumentException('Data attribute name "' . $name . '" contains illegal character ":".');
        }

        if (\strtolower(\substr($name, 0, 3)) === 'xml') {
            throw new \InvalidArgumentException('Data attribute name "' . $name . '" must not start with "xml".');
        }

        if (!$this->validateDataAttributeName($name)) {
            throw new \InvalidArgumentException('Invalid data attribute name "' . $name . '".');
        }

        if (\preg_match('/-[a-z]/', $name)) {
            throw new \InvalidArgumentException('Data attribute name "' . $name . '" must not contain a "-" followed by a lowercase character.');
        }

        // Clear value
        if (\is_null($newValue)) {
            if (isset($this->htmlWidgetTraitData[$name])) {
                unset($this->htmlWidgetTraitData[$name]);
                $this->setChanged(true);
            }
        }

        // Update value
        elseif (!$this->hasData($name) || $this->htmlWidgetTraitData[$name] !== $newValue) {
            $this->htmlWidgetTraitData[$name] = $newValue;
            $this->setChanged(true);
        }

        return $this;
    }

    /**
     * Verify the supplied name is a valid xml attribute name
     *
     * @param string $name
     * @return boolean
     * @link http://www.w3.org/TR/xml/#NT-Name
     */
    final private function validateDataAttributeName($name)
    {
        $nameStartChar = ':|[A-Z]|_|[a-z]|[\xC0-\xD6]|[\xD8-\xF6]|[\xF8-\x{2FF}]|[\x{370}-\x{37D}]|[\x{37F}-\x{1FFF}]|[\x{200C}-\x{200D}]|[\x{2070}-\x{218F}]|[\x{2C00}-\x{2FEF}]|[\x{3001}-\x{D7FF}]|[\x{F900}-\x{FDCF}]|[\x{FDF0}-\x{FFFD}]';
        // |[\x{10000}-\x{EFFFF}] must be appended according to the ref but is invalid in PHP/PCRE
        $nameChar = $nameStartChar . '|-|.|[0-9]|\xB7|[\x{0300}-\x{036F}]|[\x{203F}-\x{2040}]';

        return \preg_match('/^(' . $nameStartChar . ')(' . $nameChar . ')*$/u', $name);
    }

    /**
     * @return string
     */
    private final function renderHtmlWidgetDataAttributes() : string
    {
        $r = '';

        foreach ($this->htmlWidgetTraitData as $dataName => $dataValue) {
            $dataName = \preg_replace_callback('/[A-Z]/', function($matches) { return '-' . \strtolower($matches[0]); }, $dataName);
            $r .= Util::renderHtmlAttribute('data-' . $dataName, $dataValue);
        }

        return $r;
    }

    ######################################################################
    # Attributes handling                                                #
    ######################################################################

    protected final function renderHtmlWidgetAttributes() : string
    {
        return
            Util::renderHtmlAttribute('class', $this->htmlWidgetTraitClasses)
            . ($this->hasID() ? Util::renderHtmlAttribute('id', $this->getID()) : '')
            . Util::renderHtmlAttribute('style', $this->htmlWidgetTraitStyle)
            . Util::renderHtmlAttribute('tabindex', $this->htmlWidgetTraitTabindex)
            . Util::renderHtmlAttribute('title', $this->htmlWidgetTraitTitle)
            . $this->renderHtmlWidgetDataAttributes()
        ;
    }
}
