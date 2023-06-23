<?php

defined('TYPO3') or die();

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTcaSelectItem(
    'tt_content',
    'CType',
    [
        'label' => 'LLL:EXT:site_t3demo/Resources/Private/Language/locallang_db.xlf:CType.footerinfo.name',
        'value' => 'footerinfo',
        'icon' => 'content-info',
        'group' => 'special',
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
