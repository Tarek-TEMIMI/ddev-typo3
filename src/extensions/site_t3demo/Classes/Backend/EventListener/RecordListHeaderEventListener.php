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
use TYPO3\CMS\Backend\Controller\Event\RenderAdditionalContentToRecordListEvent;

final class RecordListHeaderEventListener
{
    public function __invoke(RenderAdditionalContentToRecordListEvent $event): void
    {
        $event->addContentAbove((new InfoHeaderService($event->getRequest()))->getInfo());
    }
}
