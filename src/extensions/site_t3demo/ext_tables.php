<?php

defined('TYPO3_MODE') or die();

(function () {
    $GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['t3lib/class.t3lib_tcemain.php']['processDatamapClass'][] =
        \B13\SiteT3demo\Hooks\Datahandler::class;
    $GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['t3lib/class.t3lib_tcemain.php']['processCmdmapClass'][] =
        \B13\SiteT3demo\Hooks\Datahandler::class;

    $GLOBALS['TBE_STYLES']['skins']['site_t3demo']['name'] = 'site_t3demo';
    $GLOBALS['TBE_STYLES']['skins']['site_t3demo']['stylesheetDirectories'] = [
        'EXT:site_t3demo/Resources/Public/Backend/Css/Skin/',
    ];

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
