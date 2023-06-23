<?php

declare(strict_types=1);

namespace B13\SiteT3demo\Backend\EventListener;

/*
 * This file is part of TYPO3 CMS-extension site_t3demo by b13.
 *
 * It is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License, either version 2
 * of the License, or any later version.
 */

use B13\SiteT3demo\RegistryInterface;
use TYPO3\CMS\Core\Authentication\Event\AfterUserLoggedInEvent;
use TYPO3\CMS\Core\Core\Environment;
use TYPO3\CMS\Core\Registry;
use TYPO3\CMS\Core\Utility\GeneralUtility;

class StartSyncTimerEventListener
{
    public function __invoke(AfterUserLoggedInEvent $event): void
    {
        if ((string)Environment::getContext() === 'Production') {
            $date = new \DateTime();
            $registry = GeneralUtility::makeInstance(Registry::class);

            $counter = $registry->get(RegistryInterface::NAMESPACE, RegistryInterface::KEY);
            if ($counter === null) {
                $date->modify('+30 minutes');
                $registry->set(RegistryInterface::NAMESPACE, RegistryInterface::KEY, $date->getTimestamp());
            }
        }
    }
}
