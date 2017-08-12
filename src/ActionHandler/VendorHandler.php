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

use \Replum\Util;
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
        $context = $this->executer->getContext();
        
        $resourceName = \rawurldecode($context->getRequest()->getPathInfo());
        $documentRoot = $context->getDocumentRoot();
        $vendorDir = $context->getVendorDir();

        try {
            @list(, $prefix, $vendor, $package, $path) = \explode('/', $resourceName, 5);

            if ($prefix !== 'vendor') {
                throw new \InvalidArgumentException('Invalid resource selection!', 1);
            }

            if (($vendor === '.') || ($vendor === '..')) {
                throw new \InvalidArgumentException('Invalid resource selection!', 2);
            }

            if (!\is_dir($vendorDir . '/' . $vendor)) {
                throw new \InvalidArgumentException('Invalid resource selection!', 3);
            }

            if (($package === '.') || ($package === '..')) {
                throw new \InvalidArgumentException('Invalid resource selection!', 4);
            }

            if (!\is_dir($vendorDir . '/' . $vendor . '/' . $package)) {
                throw new \InvalidArgumentException('Invalid resource selection!', 5);
            }

            if (\strpos($path, '..') !== false) {
                throw new \InvalidArgumentException('Invalid resource selection!', 6);
            }

            $symlinkName = $documentRoot . '/vendor/' . $vendor . '/' . $package . '/' . $path;
            $fullResourcePath = $vendorDir . '/' . $vendor . '/' . $package . '/' . ($vendor !== 'components' ? 'public/' : '') . $path;
            
            if (!\file_exists($fullResourcePath)) {
                throw new \InvalidArgumentException('Invalid resource selection!', 7);
            }

            if (!is_dir(\dirname($symlinkName)) && !\mkdir(\dirname($symlinkName), 0755, true)) {
                throw new \RuntimeException("Failed to create symlink", 8);
            }
            if (!\symlink(Util::getRelativePath($symlinkName, $fullResourcePath), $symlinkName)) {
                throw new \RuntimeException("Failed to create symlink", 9);
            }

            return new RedirectResponse($context->getUrlPrefix() . $resourceName, Response::HTTP_PERMANENTLY_REDIRECT);
        }

        catch (\Exception $e) {
            return new Response('<pre>' . $e . '</pre>', Response::HTTP_NOT_FOUND, ['content-type' => 'text/html']);
        }
    }
}
