<?php
/**
 * This file is part of Replum: the web widget framework.
 *
 * Copyright (c) Dennis Birkholz <dennis@birkholz.org>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Replum\Forms;


use Throwable;

class FieldValidationException extends \InvalidArgumentException
{
    /**
     * @var string
     */
    private $field;

    public function getField() : string
    {
        return $this->field;
    }

    public function __construct(string $field, $message = "", $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
        $this->field = $field;
    }
}
