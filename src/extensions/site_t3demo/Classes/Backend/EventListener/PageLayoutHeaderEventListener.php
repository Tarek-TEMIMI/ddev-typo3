<?php

declare(strict_types=1);

/*
 * This file is part of the package site_t3demo by b13.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace B13\SiteT3demo\Backend\EventListener;

use B13\SiteT3demo\Backend\Services\InfoHeaderService;
use TYPO3\CMS\Backend\Controller\Event\ModifyPageLayoutContentEvent;

final class PageLayoutHeaderEventListener
{
    public function __invoke(ModifyPageLayoutContentEvent $event): void
    {
        $event->addHeaderContent((new InfoHeaderService($event->getRequest()))->getInfo());
    }
}
