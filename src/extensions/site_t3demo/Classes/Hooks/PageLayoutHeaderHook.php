<?php

declare(strict_types=1);

/*
 * This file is part of the package site_t3demo by b13.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace B13\SiteT3demo\Hooks;

use TYPO3\CMS\Backend\Utility\BackendUtility;
use TYPO3\CMS\Core\Type\Bitmask\Permission;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Fluid\View\StandaloneView;

class PageLayoutHeaderHook
{
    public function drawHeader(): string
    {
        $request = $GLOBALS['TYPO3_REQUEST'];
        $pageUid = (int)($request->getParsedBody()['id'] ?? $request->getQueryParams()['id'] ?? 0);
        $pageInfo = BackendUtility::readPageAccess($pageUid, $GLOBALS['BE_USER']->getPagePermsClause(Permission::PAGE_SHOW));

        // Exit if this page does not have any notes of interest
        // If there is no header we do not add anything
        if (empty($pageInfo['infotext_header'])) {
            return '';
        }

        $view = GeneralUtility::makeInstance(StandaloneView::class);
        $view->setTemplateRootPaths(['EXT:site_t3demo/Resources/Private/Backend/Templates']);
        $view->setTemplate('PageLayout/Header');
        $view->assignMultiple([
            'data' => $pageInfo,
            'pageUid' => $pageUid,
        ]);

        return $view->render();
    }
}
