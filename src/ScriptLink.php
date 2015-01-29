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

use \nexxes\widgets\ScriptInterface;

/**
 * Description of ScriptLink
 *
 * @author dennis
 */
class ScriptLink implements ScriptInterface
{

    /**
     * The url of the style sheet
     * @var string
     */
    private $url = null;

    /**
     * @param string $url
     * @return \nexxes\widgets\html\StyleSheetLink $this for chaining
     */
    public function setUrl($url)
    {
        $this->url = $url;
        return $this;
    }

    public function __toString()
    {
        return '<script src="' . \htmlentities($this->url, null, 'UTF-8') . '?t=' . time() . '"></script>';
    }

}
