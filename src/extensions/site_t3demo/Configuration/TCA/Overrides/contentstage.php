<?php

defined('TYPO3') or die();

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTcaSelectItem(
    'tt_content',
    'CType',
    [
        'label' => 'LLL:EXT:site_t3demo/Resources/Private/Language/locallang_db.xlf:CType.contentstage.name',
        'value' => 'contentstage',
        'icon' => 'content-image',
        'group' => 'special',
    ]
);

$GLOBALS['TCA']['tt_content']['ctrl']['typeicon_classes']['contentstage'] = 'content-image';

$GLOBALS['TCA']['tt_content']['types']['contentstage'] = [
    'showitem' => $GLOBALS['TCA']['tt_content']['defaultTypeConfiguration']['begin'] . '
        header,
        --palette--;;linklabelconfig,
        image,
        ' . $GLOBALS['TCA']['tt_content']['defaultTypeConfiguration']['end'],
];
