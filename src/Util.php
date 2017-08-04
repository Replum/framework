<?php

/*
 * This file is part of Replum: the web widget framework.
 * 
 * Copyright (c) Dennis Birkholz <dennis@birkholz.org>
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Replum;

/**
 * Helper methods used by Replum
 *
 * @author Dennis Birkholz <dennis@birkholz.org>
 */
abstract class Util
{
    /**
     * Create a random string from [-a-zA-Z0-9_] as the alphabet, which is save for urls, html-ids, etc.
     */
    public static final function randomString(int $length = 8) : string
    {
        return \str_replace(['/', '+'], ['_', '-'], \substr(\base64_encode(\random_bytes($length)), 0, $length));
    }

    /**
     * Create a relative path for the $sourceFile reachable from $targetFile.
     * If $canonicalize is true, resolve all symlinks/./.. from both paths. 
     */
    public static final function getRelativePath($sourceFile, $targetFile, $canonicalize = true)
    {
        if ($canonicalize) {
            // Canonicalize
            $from = \realpath(\dirname($sourceFile));
            $to = \realpath($targetFile);
        } else {
            $from = \dirname($sourceFile);
            $to = $targetFile;
        }

        // Make array
        $from_parts = \explode('/', $from);
        $to_parts = \explode('/', $to);

        // Remove common prefix
        while (\count($from_parts) && \count($to_parts) && ($from_parts[0] == $to_parts[0])) {
            \array_shift($from_parts);
            \array_shift($to_parts);
        }

        // Source is in root directory
        if ((\count($from_parts) === 1) && ($from_parts[0] === "")) {
                $from_parts = [];
        }
        
        $path = '.';
        
        // Walk up to the common base directory
        foreach ($from_parts AS $f) {
                $path .= '/..';
        }

        // Descent into the target directory
        foreach ($to_parts AS $t) {
                $path .= '/' . $t;
        }

        // Remove leading ./
        if (\strlen($path) > 2) {
            $path = \substr($path, 2);
        }
        
        return $path;
    }
}
