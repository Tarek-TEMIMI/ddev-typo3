<?php

defined('TYPO3_MODE') or die();

(function () {
    $GLOBALS['TYPO3_CONF_VARS']['GFX']['gdlib_png'] = 1;
    $GLOBALS['TYPO3_CONF_VARS']['GFX']['gif_compress'] = 0;
    $GLOBALS['TYPO3_CONF_VARS']['GFX']['jpg_quality'] = 90;

    $GLOBALS['TYPO3_CONF_VARS']['RTE']['Presets']['default'] = 'EXT:site_t3demo/Configuration/RTE/RteConfiguration.yaml';
    $GLOBALS['TYPO3_CONF_VARS']['RTE']['Presets']['rteWithTable'] = 'EXT:site_t3demo/Configuration/RTE/RteWithTable.yaml';

    // Hook for rendering backend preview content element
    $GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['cms/layout/class.tx_cms_layout.php']['tt_content_drawItem'][] = \B13\SiteT3demo\Hooks\DrawItemDefault::class;
    $GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['cms/layout/class.tx_cms_layout.php']['tt_content_drawItem'][] = \B13\SiteT3demo\Hooks\DrawItem::class;

    // show additional information in page layout header for "Notes of Interest".
    $GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['cms/layout/db_layout.php']['drawHeaderHook'][]
        = \B13\SiteT3demo\Hooks\PageLayoutHeaderHook::class . '->drawHeader';
    $GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['recordlist/Modules/Recordlist/index.php']['drawHeaderHook'][]
        = \B13\SiteT3demo\Hooks\PageLayoutHeaderHook::class . '->drawHeader';

    // remove the default textpic and text preview renderer (we want to use our own preview renderer exclusively
    unset(
        $GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['cms/layout/class.tx_cms_layout.php']['tt_content_drawItem']['textmedia'],
        $GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['cms/layout/class.tx_cms_layout.php']['tt_content_drawItem']['textpic'],
        $GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['cms/layout/class.tx_cms_layout.php']['tt_content_drawItem']['text']
    );

    // add our own icons to the icon registry
    $iconRegistry = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\TYPO3\CMS\Core\Imaging\IconRegistry::class);

    $iconsToRegister = [
        'b13-teaser-image',
        'apps-pagetree-page-apple',
        'apps-pagetree-page-apple-hideinmenu',
        'apps-pagetree-page-overview',
        'apps-pagetree-page-overview-hideinmenu',
        'apps-pagetree-page-recipe',
        'apps-pagetree-page-recipe-hideinmenu',
    ];

    foreach ($iconsToRegister as $icon) {
        $iconRegistry->registerIcon(
            $icon,
            \TYPO3\CMS\Core\Imaging\IconProvider\SvgIconProvider::class,
            [
                'source' => 'EXT:site_t3demo/Resources/Public/Assets/Icons/' . $icon . '.svg',
            ]
        );
    }
    // add exclamation mark icon to the icon registry (for warnings in backend element previews)
    $iconRegistry->registerIcon(
        'exclamation-triangle',
        \TYPO3\CMS\Core\Imaging\IconProvider\FontawesomeIconProvider::class,
        [
            'name' => 'exclamation-triangle',
        ]
    );
    $iconRegistry->registerIcon(
        'exclamation-circle',
        \TYPO3\CMS\Core\Imaging\IconProvider\FontawesomeIconProvider::class,
        [
            'name' => 'exclamation-circle',
        ]
    );

    if ((string)\TYPO3\CMS\Core\Core\Environment::getContext() === 'Production') {
        $GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['t3lib/class.t3lib_userauthgroup.php']['backendUserLogin'][] =
            \B13\SiteT3demo\Hooks\StartSyncTimerHook::class . '->dispatch';

        $GLOBALS['TYPO3_CONF_VARS']['BE']['toolbarItems'][1602858625] = \B13\SiteT3demo\Backend\ToolbarItems\TimerToolbarItem::class;
        $iconRegistry->registerIcon(
            'b13-demo-content-sync-timer',
            \TYPO3\CMS\Core\Imaging\IconProvider\SvgIconProvider::class,
            [
                'source' => 'EXT:site_t3demo/Resources/Public/Icons/clock.svg',
            ]
        );
    }

    // Remove the doktypes we do not use
    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addUserTSConfig('options.pageTree.doktypesToShowInNewPageDragArea := removeFromList(7,255,199)');
})();
