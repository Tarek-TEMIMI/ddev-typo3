<?php

defined('TYPO3') or die();

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTcaSelectItem(
    'tt_content',
    'CType',
    [
        'label' => 'LLL:EXT:site_t3demo/Resources/Private/Language/locallang_db.xlf:CType.ingredients.name',
        'value' => 'ingredients',
        'icon' => 'content-table',
        'group' => 'common',
    ]
);

$GLOBALS['TCA']['tt_content']['ctrl']['typeicon_classes']['ingredients'] = 'content-table';

$GLOBALS['TCA']['tt_content']['types']['ingredients'] = [
    'showitem' => $GLOBALS['TCA']['tt_content']['defaultTypeConfiguration']['begin'] . '
        --palette--;;headers,
        bodytext,
        ' . $GLOBALS['TCA']['tt_content']['defaultTypeConfiguration']['end'],
    'columnsOverrides' => [
        'bodytext' => [
            'config' => [
                'enableRichtext' => true,
                'richtextConfiguration' => 'rteWithTable',
            ],
        ],
    ],
];
