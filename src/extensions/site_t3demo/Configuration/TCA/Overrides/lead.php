<?php

defined('TYPO3') or die();

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTcaSelectItem(
    'tt_content',
    'CType',
    [
        'label' => 'LLL:EXT:site_t3demo/Resources/Private/Language/locallang_db.xlf:CType.lead.name',
        'value' => 'lead',
        'icon' => 'content-header',
        'group' => 'common',
    ]
);

$GLOBALS['TCA']['tt_content']['ctrl']['typeicon_classes']['lead'] = 'content-header';

$GLOBALS['TCA']['tt_content']['types']['lead'] = [
    'showitem' => $GLOBALS['TCA']['tt_content']['defaultTypeConfiguration']['begin'] . '
        bodytext,
        ' . $GLOBALS['TCA']['tt_content']['defaultTypeConfiguration']['end'],
];
