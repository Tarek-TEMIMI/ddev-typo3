<?php

declare(strict_types=1);

namespace B13\SiteT3demo\Hooks;

/*
 * This file is part of TYPO3 CMS-extension site_t3demo by b13.
 *
 * It is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License, either version 2
 * of the License, or any later version.
 */

use TYPO3\CMS\Backend\View\PageLayoutView;
use TYPO3\CMS\Backend\View\PageLayoutViewDrawItemHookInterface;
use TYPO3\CMS\Core\Database\Connection;
use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Database\Query\Restriction\DeletedRestriction;
use TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 * Class/Function which manipulates the rendering of item example content
 */
class DrawItem implements PageLayoutViewDrawItemHookInterface
{

    /**
     * @param PageLayoutView $parentObject : The parent object that triggered this hook
     * @param bool $drawItem : A switch to tell the parent object, if the item still must be drawn
     * @param string $headerContent : The content of the item header
     * @param string $itemContent : The content of the item itself
     * @param array $row : The current data row for this item
     */
    public function preProcess(PageLayoutView &$parentObject, &$drawItem, &$headerContent, &$itemContent, array &$row)
    {
        if ($row['CType'] === 'menu_pages') {
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
                    $queryBuilder->expr()->in('uid', $queryBuilder->createNamedParameter(explode(',', $row['pages']), Connection::PARAM_INT_ARRAY))
                );
            $row['relatedPages'] = $queryBuilder
                ->executeQuery()
                ->fetchAllAssociative();
        }

        if ($row['CType'] === 'menu_subpages') {
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
                    $queryBuilder->expr()->in('pid', $queryBuilder->createNamedParameter(explode(',', ((string)$row['pages'] ?: (string)$row['pid'])), Connection::PARAM_INT_ARRAY))
                );
            $row['subPages'] = $queryBuilder
                ->executeQuery()
                ->fetchAllAssociative();
        }

        if ($row['CType'] === 'pageheader') {
            $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)
                ->getQueryBuilderForTable('tt_content');
            $queryBuilder
                ->select('uid')
                ->from('tt_content')
                ->orderBy('sorting')
                ->where(
                    $queryBuilder->expr()->eq('pid', $queryBuilder->createNamedParameter($row['pid'])),
                    $queryBuilder->expr()->eq('CType', $queryBuilder->createNamedParameter('pageheader')),
                    $queryBuilder->expr()->eq('sys_language_uid', $queryBuilder->createNamedParameter($row['sys_language_uid']))
                );
            $row['allPageHeadersOnCurrentPage'] = $queryBuilder
                ->executeQuery()
                ->fetchAllAssociative();
        }

        // process bodytext (rte) fields to remove unwanted HTML tags
        $listOfCTypesToProcess = [
            'text',
            'textpic',
            'textmedia',
            'keyvisual',
        ];
        if (in_array($row['CType'], $listOfCTypesToProcess)) {
            if ($row['bodytext']) {
                $row['bodytext_processed'] = $parentObject->renderText($row['bodytext']);
            }
        }
    }
}
