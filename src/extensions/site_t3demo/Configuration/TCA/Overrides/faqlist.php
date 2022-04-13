<?php

defined('TYPO3_MODE') or die();

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTcaSelectItem(
    'tt_content',
    'CType',
    [
        'LLL:EXT:site_t3demo/Resources/Private/Language/locallang_db.xlf:CType.faqlist.name',
        'faqlist',
        'mimetypes-x-faq_t3demo',
        'special',
    ]
);

$GLOBALS['TCA']['tt_content']['ctrl']['typeicon_classes']['faqlist'] = 'mimetypes-x-faq_t3demo';

$GLOBALS['TCA']['tt_content']['types']['faqlist'] = [
    'showitem' => $GLOBALS['TCA']['tt_content']['defaultTypeConfiguration']['begin'] . '
        --palette--;;headers,
        bodytext,
        ' . $GLOBALS['TCA']['tt_content']['defaultTypeConfiguration']['end'],
    'columnsOverrides' => [
        'bodytext' => [
            'config' => [
                'enableRichtext' => true,
            ],
        ],
    ],
];
