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
 * Implements AriaAttributesInterface
 *
 * @author Dennis Birkholz <dennis@birkholz.org>
 */
trait AriaAttributesTrait
{
    ######################################################################
    # Role attribute                                                     #
    ######################################################################

    /**
     * Roles are defined and described by their characteristics. Characteristics define the structural function of a role, such as what a role is, concepts behind it, and what instances the role can or must contain. In the case of widgets this also includes how it interacts with the user agent based on mapping to HTML forms and XForms. States and properties from WAI-ARIA that are supported by the role are also indicated.
     *
     * @var string
     * @link http://www.w3.org/TR/html5/dom.html#aria-role-attribute
     * @link http://www.w3.org/TR/wai-aria/roles
     */
    private $ariaAttributesTraitRole;

    /**
     * @see \Replum\Html\AriaAttributesInterface::getRole()
     */
    public function getRole() : string
    {
        return $this->ariaAttributesTraitRole;
    }

    /**
     * @see \Replum\Html\AriaAttributesInterface::hasRole()
     */
    public function hasRole() : bool
    {
        return !\is_null($this->ariaAttributesTraitRole);
    }

    /**
     * @see \Replum\Html\AriaAttributesInterface::setRole()
     */
    public function setRole(string $newRole = null) : AriaAttributesInterface
    {
        if (!\in_array($newRole, $this->validRoles())) {
            throw new \InvalidArgumentException('Invalid ARIA role "' . $newRole . '"!');
        }

        if ($this->ariaAttributesTraitRole !== $newRole) {
            $this->ariaAttributesTraitRole = $newRole;
            $this->setChanged(true);
        }

        return $this;
    }

    /**
     * List of available roles.
     * Overwrite method to limit roles for this element.
     *
     * @link http://www.w3.org/TR/wai-aria/appendices#quickref
     */
    protected function validRoles() : array
    {
        return [
            'alert', 'alertdialog', 'application', 'article', 'banner',
            'button', 'checkbox', 'columnheader', 'combobox', 'complementary',
            'contentinfo', 'definition', 'dialog', 'directory', 'document',
            'form', 'grid', 'gridcell', 'group', 'heading',
            'img', 'link', 'list', 'listbox', 'listitem',
            'log', 'main', 'marquee', 'math', 'menu',
            'menubar', 'menuitem', 'menuitemcheckbox', 'menuitemradio', 'navigation',
            'note', 'option', 'presentation', 'progressbar', 'radio',
            'radiogroup', 'region', 'row', 'rowgroup', 'rowheader',
            'search', 'separator', 'scrollbar', 'slider', 'spinbutton',
            'status', 'tab', 'tablist', 'tabpanel', 'textbox',
            'timer', 'toolbar', 'tooltip', 'tree', 'treegrid',
            'treeitem',
        ];
    }
}
