<?php

// clear the default items for "layout" field to allow for consistent adding of additional items with addItems in
// PageTSConfig (instead of a combination of altLabels and addItems
$GLOBALS['TCA']['tt_content']['columns']['layout']['config']['items'] = [];
unset($GLOBALS['TCA']['tt_content']['columns']['layout']['config']['default']);

// save a default configuration for showitems to use in our own content elements
$showItemParts = explode('--div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:language,', $GLOBALS['TCA']['tt_content']['types']['textmedia']['showitem']);
$GLOBALS['TCA']['tt_content']['defaultTypeConfiguration']['begin'] = '--palette--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:palette.general;general,';
$GLOBALS['TCA']['tt_content']['defaultTypeConfiguration']['end'] = '--div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:language,' . $showItemParts[1];

$GLOBALS['TCA']['tt_content']['columns']['imageorient']['config']['items'] = [
    ['LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:imageorient.I.0', 0, 'content-beside-text-img-above-center'],
    ['LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:imageorient.I.6', 17, 'content-inside-text-img-right'],
    ['LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:imageorient.I.7', 18, 'content-inside-text-img-left'],
];

$GLOBALS['TCA']['tt_content']['columns']['linkconfig']['config']['items'] = [
    ['LLL:EXT:site_t3demo/Resources/Private/Language/locallang_db.xlf:cta.linkconfig.I.0', 0],
    ['LLL:EXT:site_t3demo/Resources/Private/Language/locallang_db.xlf:cta.linkconfig.I.primary', 'primary'],
    ['LLL:EXT:site_t3demo/Resources/Private/Language/locallang_db.xlf:cta.linkconfig.I.secondary', 'secondary'],
];

$GLOBALS['TCA']['tt_content']['columns']['header_layout']['config']['items'] = [
    ['LLL:EXT:site_t3demo/Resources/Private/Language/locallang_db.xlf:tt_content.header_layout.I.default_value', '0'],
    ['LLL:EXT:site_t3demo/Resources/Private/Language/locallang_db.xlf:tt_content.header_layout.I.1', '1'],
    ['LLL:EXT:site_t3demo/Resources/Private/Language/locallang_db.xlf:tt_content.header_layout.I.2', '2'],
    ['LLL:EXT:site_t3demo/Resources/Private/Language/locallang_db.xlf:tt_content.header_layout.I.3', '3'],
    ['LLL:EXT:site_t3demo/Resources/Private/Language/locallang_db.xlf:tt_content.header_layout.I.4', '4'],
    ['LLL:EXT:site_t3demo/Resources/Private/Language/locallang_db.xlf:tt_content.header_layout.I.5', '5'],
    ['LLL:EXT:site_t3demo/Resources/Private/Language/locallang_db.xlf:tt_content.header_layout.I.100', '100'],
];

$GLOBALS['TCA']['tt_content']['types']['menu_pages']['columnsOverrides']['pages']['description'] =
    'LLL:EXT:site_t3demo/Resources/Private/Language/locallang_db.xlf:tt_content.pages.types.menu_pages.description'
;

$GLOBALS['TCA']['tt_content']['types']['menu_subpages']['columnsOverrides']['pages']['description'] =
    'LLL:EXT:site_t3demo/Resources/Private/Language/locallang_db.xlf:tt_content.pages.types.menu_subpages.description'
;

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addToAllTCAtypes(
    'tt_content',
    '--palette--;;linklabelconfig',
    'menu_pages',
    'after:pages'
);
