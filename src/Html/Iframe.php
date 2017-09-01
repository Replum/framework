<?php

/**
 * This file is part of Replum: the web widget framework.
 *
 * Copyright (c) Dennis Birkholz <dennis@birkholz.org>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Replum\Html;

use \Replum\Html\Attributes\HeightWidthAttributesTrait;
use \Replum\Html\Attributes\SrcAttributeTrait;
use Replum\Util;

/**
 * The iframe element represents a nested browsing context.
 *
 * @author Dennis Birkholz <dennis@birkholz.org>
 * @link https://www.w3.org/TR/html5/embedded-content-0.html#the-iframe-element
 */
final class Iframe extends HtmlElement implements FlowElementInterface
{
    use HeightWidthAttributesTrait;
    use SrcAttributeTrait;

    const TAG = 'iframe';

    ######################################################################
    # src attribute                                                      #
    ######################################################################

    // from SrcAttributeTrait

    ######################################################################
    # srcdoc attribute                                                   #
    ######################################################################

    /**
     * A document to render in the iframe
     * @var string
     * @link https://www.w3.org/TR/html5/embedded-content-0.html#attr-iframe-srcdoc
     */
    private $srcdoc;

    /**
     * Get the document to render in the iframe
     */
    final public function getSrcdoc() : string
    {
        return $this->srcdoc;
    }

    /**
     * Check whether the document to render in the iframe is set
     */
    final public function hasSrcdoc() : bool
    {
        return ($this->srcdoc !== null);
    }

    /**
     * Set the document to render in the iframe
     *
     * @return static $this
     */
    final public function setSrcdoc(string $srcdoc = null) : self
    {
        if ($this->srcdoc !== $srcdoc) {
            $this->srcdoc = $srcdoc;
            $this->setChanged(true);
        }
        return $this;
    }

    ######################################################################
    # name attribute                                                     #
    ######################################################################

    /**
     * Name of nested browsing context
     * @var string
     * @link https://www.w3.org/TR/html5/embedded-content-0.html#attr-iframe-name
     */
    private $name;

    /**
     * Get the name of nested browsing context
     */
    final public function getName() : string
    {
        return $this->name;
    }

    /**
     * Check whether name of nested browsing context is set
     */
    final public function hasName() : bool
    {
        return ($this->name !== null);
    }

    /**
     * Set the name of nested browsing context
     *
     * @return static $this
     */
    final public function setName(string $name = null) : self
    {
        if ($this->name !== $name) {
            $this->name = $name;
            $this->setChanged(true);
        }
        return $this;
    }

    ######################################################################
    # sandbox attribute                                                  #
    ######################################################################

    const SANDBOX_ALLOW_FORMS = 'allow-forms';
    const SANDBOX_ALLOW_POINTER_LOCK = 'allow-pointer-lock';
    const SANDBOX_ALLOW_POPUPS = 'allow-popups';
    const SANDBOX_ALLOW_SAME_ORIGIN = 'allow-same-origin';
    const SANDBOX_ALLOW_SCRIPTS = 'allow-scripts';
    const SANDBOX_ALLOW_TOP_NAVIGATION = 'allow-top-navigation';

    const SANDBOX_FEATURES = [
        self::SANDBOX_ALLOW_FORMS,
        self::SANDBOX_ALLOW_POINTER_LOCK,
        self::SANDBOX_ALLOW_POPUPS,
        self::SANDBOX_ALLOW_SAME_ORIGIN,
        self::SANDBOX_ALLOW_SCRIPTS,
        self::SANDBOX_ALLOW_TOP_NAVIGATION,
    ];

    /**
     * The sandbox attribute, when specified, enables a set of extra restrictions on any content hosted by the iframe.
     *
     * @var bool
     * @link https://www.w3.org/TR/html5/embedded-content-0.html#attr-iframe-sandbox
     */
    private $sandbox = false;

    /**
     * Enabled SANDBOX_ALLOW_* features
     *
     * @var string[]
     */
    private $sandboxFeatures = [];

    /**
     * Check whether security rules for nested content are enabled
     */
    final public function getSandbox() : bool
    {
        return $this->sandbox;
    }

    /**
     * Enable/disable security rules for nested content
     */
    final public function setSandbox(bool $sandbox) : self
    {
        if ($this->sandbox !== $sandbox) {
            $this->sandbox = $sandbox;
            $this->setChanged(true);
        }
        return $this;
    }

    /**
     * @return string[]
     */
    final public function getSandboxFeatures() : array
    {
        return \array_keys($this->sandboxFeatures);
    }

    /**
     * Enable one or more of the SANDBOX_ALLOW_* features IN ADDITION to already set features
     */
    final public function addSandboxFeature(string ...$restrictions) : self
    {
        $changed = false;

        if (\count($restrictions)) {
            $changed = ($this->sandbox !== true);
            $this->sandbox = true;
        }

        foreach ($restrictions as $restriction) {
            $realRestriction = \strtolower($restriction);

            if (!\in_array($realRestriction, self::SANDBOX_FEATURES, true)) {
                throw new \InvalidArgumentException('Invalid sandbox restriction "' . $restriction . '"!');
            }

            if (!isset($this->sandboxFeatures[$realRestriction])) {
                $this->sandboxFeatures[$realRestriction] = true;
                $changed = true;
            }
        }

        if ($changed) {
            $this->setChanged(true);
        }

        return $this;
    }

    /**
     * Disable one or more of the SANDBOX_ALLOW_* features from the currently set features
     */
    final public function delSandboxFeature(string ...$restrictions) : self
    {
        $changed = false;

        if (\count($restrictions)) {
            $changed = ($this->sandbox !== true);
            $this->sandbox = true;
        }

        foreach ($restrictions as $restriction) {
            $realRestriction = \strtolower($restriction);

            if (!\in_array($realRestriction, self::SANDBOX_FEATURES, true)) {
                throw new \InvalidArgumentException('Invalid sandbox restriction "' . $restriction . '"!');
            }

            if (isset($this->sandboxFeatures[$realRestriction])) {
                unset($this->sandboxFeatures[$realRestriction]);
                $changed = true;
            }
        }

        if ($changed) {
            $this->setChanged(true);
        }

        return $this;
    }

    /**
     * Unset all SANDBOX_ALLOW_* features
     */
    final public function clearSandboxFeatures() : self
    {
        if ($this->sandboxFeatures !== []) {
            $this->sandboxFeatures = [];
            $this->setChanged(true);
        }
        return $this;
    }

    ######################################################################
    # width attribute                                                    #
    ######################################################################

    // from HeightWidthAttributesTrait

    ######################################################################
    # height attribute                                                   #
    ######################################################################

    // from HeightWidthAttributesTrait

    ######################################################################
    # rendering                                                          #
    ######################################################################

    protected function renderAttributes(): string
    {
        return parent::renderAttributes()
            . $this->renderHeightWidthAttributes()
            . $this->renderSrcAttribute()
            . Util::renderHtmlAttribute('srcdoc', $this->srcdoc)
            . Util::renderHtmlAttribute('name', $this->name)
            . Util::renderHtmlAttribute('sandbox', ($this->sandbox && \count($this->sandboxFeatures) > 0 ? $this->sandboxFeatures : $this->sandbox))
        ;
    }
}
