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

use Doctrine\DBAL\ArrayParameterType;
use TYPO3\CMS\Backend\View\Event\PageContentPreviewRenderingEvent;
use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Database\Query\Restriction\DeletedRestriction;
use TYPO3\CMS\Core\Utility\GeneralUtility;

final class DrawItemEventListener
{
    public function __invoke(PageContentPreviewRenderingEvent $event): void
    {
        if ($event->getTable() !== 'tt_content') {
            return;
        }

        $record = $event->getRecord();

        if ($event->getRecord()['CType'] === 'menu_pages') {
            $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)
                ->getQueryBuilderForTable('pages');
            $queryBuilder
                ->getRestrictions()
                ->removeAll()
                ->add(GeneralUtility::makeInstance(DeletedRestriction::class));
            $queryBuilder
                ->select('*')
                ->from('pages')
                ->where(
                    $queryBuilder->expr()->in('uid', $queryBuilder->createNamedParameter(explode(',', $record['pages']), ArrayParameterType::INTEGER))
                );
            $record['relatedPages'] = $queryBuilder
                ->executeQuery()
                ->fetchAllAssociative();
        }

        if ($event->getRecord()['CType'] === 'menu_subpages') {
            $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)
                ->getQueryBuilderForTable('pages');
            $queryBuilder
                ->getRestrictions()
                ->removeAll()
                ->add(GeneralUtility::makeInstance(DeletedRestriction::class));
            $queryBuilder
                ->select('*')
                ->from('pages')
                ->where(
                    $queryBuilder->expr()->in('pid', $queryBuilder->createNamedParameter(explode(',', ((string)$record['pages'] ?: (string)$record['pid'])), ArrayParameterType::INTEGER)),
                    $queryBuilder->expr()->eq(
                        'sys_language_uid',
                        $queryBuilder->createNamedParameter($record['sys_language_uid'])
                    )
                );
            $record['subPages'] = $queryBuilder
                ->executeQuery()
                ->fetchAllAssociative();
        }

        $event->setRecord($record);
    }
}
