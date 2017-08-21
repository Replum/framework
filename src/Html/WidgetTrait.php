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
    public function addClass(string $newClass) : WidgetInterface
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
    public function delClass(string $class, bool $isRegex = false) : WidgetInterface
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
    public function hasClass(string $class, bool $isRegex = false) : bool
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
    public function getClasses(bool $regex = null) : array
    {
        \sort($this->htmlWidgetTraitClasses);

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
     * The page unique identifier for this widget
     *
     * @var string
     */
    private $htmlWidgetTraitId;

    /**
     * @see \Replum\Html\WidgetInterface::hasID()
     */
    public function hasID() : bool
    {
        return ($this->htmlWidgetTraitId !== null);
    }

    /**
     * @see \Replum\Html\WidgetInterface::getID()
     */
    public function getID() : string
    {
        if (!$this->hasID()) {
            $this->needID();
        }
        return $this->htmlWidgetTraitId;
    }

    /**
     * @see \Replum\Html\WidgetInterface::setID()
     */
    public function setID(string $newID) : WidgetInterface
    {
        // Ignore resettings same ID
        if ($this->htmlWidgetTraitId === $newID) {
            return $this;
        }

        if ($this->getPage()->registerID($newID)) {
            $this->htmlWidgetTraitId = $newID;
            $this->setChanged(true);
            return $this;
        } else {
            return $this;
        }
    }

    /**
     * @see \Replum\Html\WidgetInterface::needID()
     */
    public function needID() : WidgetInterface
    {
        $this->htmlWidgetTraitId = $this->getPage()->generateID();
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
    public function getStyle() : string
    {
        return $this->htmlWidgetTraitStyle;
    }

    /**
     * @see \Replum\Html\WidgetInterface::hasStyle()
     */
    public function hasStyle() : bool
    {
        return ($this->htmlWidgetTraitStyle !== null);
    }

    /**
     * @see \Replum\Html\WidgetInterface::setStyle()
     */
    public function setStyle(string $newStyle = null) : WidgetInterface
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
    public function getTabIndex() : int
    {
        return $this->htmlWidgetTraitTabindex;
    }

    /**
     * @see \Replum\Html\WidgetInterface::hasTabIndex()
     */
    public function hasTabIndex() : bool
    {
        return ($this->htmlWidgetTraitTabindex !== null);
    }

    /**
     * @see \Replum\WidgetInterface::setTabIndex()
     */
    public function setTabIndex(int $newTabIndex = null) : WidgetInterface
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
    public function getTitle() : string
    {
        return $this->htmlWidgetTraitTitle;
    }

    /**
     * @see \Replum\Html\WidgetInterface::hasTitle()
     */
    public function hasTitle() : bool
    {
        return ($this->htmlWidgetTraitTitle !== null);
    }

    /**
     * @see \Replum\Html\WidgetInterface::setTitle()
     */
    public function setTitle(string $newTitle = null) : WidgetInterface
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
    public function addData(string $name, string $value) : WidgetInterface
    {
        return $this->setData($name, ($this->hasData($name) ? $this->getData($name) . ' ' : '') . $value);
    }

    /**
     * @see \Replum\Html\WidgetInterface::getData()
     */
    public function getData(string $name) : string
    {
        if (!$this->hasData($name)) {
            throw new \InvalidArgumentException("No data set for data attribute '$name'!");
        }

        return $this->htmlWidgetTraitData[$name];
    }

    /**
     * @see \Replum\Html\WidgetInterface::getDataset()
     */
    public function getDataset() : array
    {
        return $this->htmlWidgetTraitData;
    }

    /**
     * @see \Replum\Html\WidgetInterface::hasData()
     */
    public function hasData(string $name) : bool
    {
        return isset($this->htmlWidgetTraitData[$name]);
    }

    /**
     * @see \Replum\Html\WidgetInterface::setData()
     */
    public function setData(string $name, string $newValue = null) : WidgetInterface
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

        if (!$this->validateAttributeName($name)) {
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
}
