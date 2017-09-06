<?php
/**
 * This file is part of Replum: the web widget framework.
 *
 * Copyright (c) Dennis Birkholz <dennis@birkholz.org>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Replum;


class WidgetMock implements WidgetContainerInterface
{
    use WidgetContainerTrait;

    public function render(): string
    {
        return '';
    }
}
