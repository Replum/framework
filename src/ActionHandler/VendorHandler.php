<?php

/*
 * This file is part of Replum: the web widget framework.
 *
 * Copyright (c) Dennis Birkholz <dennis@birkholz.org>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Replum\ActionHandler;

use \nexxes\common\RelativePath;
use \Symfony\Component\HttpFoundation\Response;
use \Symfony\Component\HttpFoundation\RedirectResponse;

/**
 * @author Dennis Birkholz <dennis@birkholz.org>
 */
class VendorHandler
{
    /**
     * @var \Replum\Executer
     */
    private $executer;

    public function __construct(\Replum\Executer $executer)
    {
        $this->executer = $executer;
    }

    public function execute()
    {
        $resourceName = \rawurldecode($this->executer->getRequest()->getPathInfo());

        try {
            $this->createVendorResourceSymlink($resourceName, VENDOR_DIR, $this->executer->getRequest()->server->get('DOCUMENT_ROOT'));
        } catch (\Exception $e) {
            return new Response('<pre>' . $e . '</pre>', Response::HTTP_NOT_FOUND, ['content-type' => 'text/html']);
        }

        return new RedirectResponse($resourceName, Response::HTTP_PERMANENTLY_REDIRECT);
    }

    /**
     * @param string $resourceName The resource name = path below the document root
     * @param string $vendor_dir Vendor dir used by composer to install dependencies into
     * @param string $document_root Directory that is accessible thru the web server
     * @throws \InvalidArgumentException
     * @see self::handleVendorResource
     */
    protected function createVendorResourceSymlink($resourceName, $vendor_dir, $document_root)
    {
        @list(, $prefix, $vendor, $package, $path) = \explode('/', $resourceName, 5);

        if ($prefix != 'vendor') {
            throw new \InvalidArgumentException('Invalid resource selection!', 1);
        }

        if (($vendor == '.') || ($vendor == '..')) {
            throw new \InvalidArgumentException('Invalid resource selection!', 2);
        }

        if (!\is_dir($vendor_dir . '/' . $vendor)) {
            throw new \InvalidArgumentException('Invalid resource selection!', 3);
        }

        if (($package == '.') || ($package == '..')) {
            throw new \InvalidArgumentException('Invalid resource selection!', 4);
        }

        if (!\is_dir($vendor_dir . '/' . $vendor . '/' . $package)) {
            throw new \InvalidArgumentException('Invalid resource selection!', 5);
        }

        if (!\is_dir($vendor_dir . '/' . $vendor . '/' . $package . '/public')) {
            throw new \InvalidArgumentException('Invalid resource selection!', 6);
        }

        if (\strpos($path, '..') !== false) {
            throw new \InvalidArgumentException('Invalid resource selection!', 7);
        }

        if (!\file_exists($vendor_dir . '/' . $vendor . '/' . $package . '/public/' . $path)) {
            throw new \InvalidArgumentException('Invalid resource selection!', 8);
        }

        $linkname = $document_root . '/vendor/' . $vendor . '/' . $package . '/' . $path;
        $fulltarget = $vendor_dir . '/' . $vendor . '/' . $package . '/public/' . $path;

        \mkdir(\dirname($linkname), 0755, true);
        \symlink((string)new RelativePath($linkname, $fulltarget), $linkname);
    }
}
