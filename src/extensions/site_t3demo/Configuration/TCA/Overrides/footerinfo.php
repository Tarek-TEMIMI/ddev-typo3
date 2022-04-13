<?php

defined('TYPO3_MODE') or die();

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTcaSelectItem(
    'tt_content',
    'CType',
    [
        'LLL:EXT:site_t3demo/Resources/Private/Language/locallang_db.xlf:CType.footerinfo.name',
        'footerinfo',
        'content-info',
        'special',
    ]
);

$GLOBALS['TCA']['tt_content']['ctrl']['typeicon_classes']['footerinfo'] = 'content-info';

$GLOBALS['TCA']['tt_content']['types']['footerinfo'] = [
    'showitem' => $GLOBALS['TCA']['tt_content']['defaultTypeConfiguration']['begin'] . '
        header,
        bodytext,
        --palette--;;linklabel,
        ' . $GLOBALS['TCA']['tt_content']['defaultTypeConfiguration']['end'],
];
