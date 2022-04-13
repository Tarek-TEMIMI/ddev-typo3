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

use TYPO3\CMS\Backend\Routing\UriBuilder;
use TYPO3\CMS\Backend\Utility\BackendUtility;
use TYPO3\CMS\Backend\View\PageLayoutView;
use TYPO3\CMS\Backend\View\PageLayoutViewDrawItemHookInterface;
use TYPO3\CMS\Core\Authentication\BackendUserAuthentication;
use TYPO3\CMS\Core\Localization\LanguageService;
use TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 * Class/Function which manipulates the rendering of item example content
 */
class DrawItemDefault implements PageLayoutViewDrawItemHookInterface
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
        if ($this->getBackendUser()->recordEditAccessInternals('tt_content', $row)) {
            $urlParameters = [
                'edit' => [
                    'tt_content' => [
                        $row['uid'] => 'edit',
                    ],
                ],
                'returnUrl' => GeneralUtility::getIndpEnv('REQUEST_URI') . '#element-tt_content-' . $row['uid'],
            ];
            $uriBuilder = GeneralUtility::makeInstance(UriBuilder::class);
            $url = (string)$uriBuilder->buildUriFromRoute('record_edit', $urlParameters);
            $return = [
                'url' => htmlspecialchars($url),
                'title' => htmlspecialchars($this->getLanguageService()->getLL('edit')),
            ];
            $row['editLink'] = $return;
        }

        // return all sys_file_reference rows
        if ($row['assets']) {
            $row['allAssets'] = \B13\SiteT3demo\Service\FilereferenceService::resolveFilereferences('assets', 'tt_content', $row['uid']);
            $row['allAssets-numberOfVisibleItems'] = \B13\SiteT3demo\Service\FilereferenceService::countNumberOfVisibleFilereferences('assets', 'tt_content', $row['uid']);
        }
        if ($row['media']) {
            $row['allMedia'] = \B13\SiteT3demo\Service\FilereferenceService::resolveFilereferences('media', 'tt_content', $row['uid']);
            $row['allMedia-numberOfVisibleItems'] = \B13\SiteT3demo\Service\FilereferenceService::countNumberOfVisibleFilereferences('media', 'tt_content', $row['uid']);
        }
        if ($row['image']) {
            $row['allImages'] = \B13\SiteT3demo\Service\FilereferenceService::resolveFilereferences('image', 'tt_content', $row['uid']);
            $row['allImages-numberOfVisibleItems'] = \B13\SiteT3demo\Service\FilereferenceService::countNumberOfVisibleFilereferences('image', 'tt_content', $row['uid']);
        }
    }

    /**
     * Returns the language service
     * @return LanguageService
     */
    protected function getLanguageService()
    {
        return $GLOBALS['LANG'];
    }

    /**
     * @return BackendUserAuthentication
     */
    protected function getBackendUser()
    {
        return $GLOBALS['BE_USER'];
    }

    /**
     * Create thumbnail code for record/field but not linked
     *
     * @param mixed[] $row Record array
     * @param string $table Table (record is from)
     * @param string $field Field name for which thumbnail are to be rendered.
     * @return string HTML for thumbnails, if any.
     */
    public function getThumbCodeUnlinked($row, $table, $field)
    {
        return BackendUtility::thumbCode($row, $table, $field, '', '', null, 0, 'style="margin-right: 10px;"', '', false);
    }
}
