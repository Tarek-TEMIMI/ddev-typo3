<?php

defined('TYPO3') or die();

(function () {
    $GLOBALS['TYPO3_CONF_VARS']['BE']['stylesheets']['site_t3demo_backend'] = 'EXT:site_t3demo/Resources/Public/Backend/Css/Skin/t3skin_override.css';

    // Build or own drop in flyout menu for creating new pages, in the order we prefer
    $allDoktypesForFlyoutMenu = [
        \B13\SiteT3demo\PageConfiguration::DOKTYPE_CONTENTPAGE,
        \B13\SiteT3demo\PageConfiguration::DOKTYPE_APPLE,
        \B13\SiteT3demo\PageConfiguration::DOKTYPE_RECIPE,
        \B13\SiteT3demo\PageConfiguration::DOKTYPE_OVERVIEW,
        \TYPO3\CMS\Core\Domain\Repository\PageRepository::DOKTYPE_SHORTCUT,
        \TYPO3\CMS\Core\Domain\Repository\PageRepository::DOKTYPE_LINK,
        \TYPO3\CMS\Core\Domain\Repository\PageRepository::DOKTYPE_SYSFOLDER,
    ];
    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addUserTSConfig(
        'options.pageTree.doktypesToShowInNewPageDragArea = ' . implode(',', $allDoktypesForFlyoutMenu)
    );
})();
