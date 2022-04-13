<?php

defined('TYPO3_MODE') or die();

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTcaSelectItem(
    'tt_content',
    'CType',
    [
        'LLL:EXT:site_t3demo/Resources/Private/Language/locallang_db.xlf:CType.mainteaser.name',
        'mainteaser',
        'b13-teaser-image',
        'special',
    ]
);

$GLOBALS['TCA']['tt_content']['ctrl']['typeicon_classes']['mainteaser'] = 'b13-teaser-image';

$GLOBALS['TCA']['tt_content']['types']['mainteaser'] = [
    'showitem' => $GLOBALS['TCA']['tt_content']['defaultTypeConfiguration']['begin'] . '
        header,
        bodytext,
        link,
        image,
        ' . $GLOBALS['TCA']['tt_content']['defaultTypeConfiguration']['end'],
    'columnsOverrides' => [
        'bodytext' => [
            'config' => [
                'rows' => 5,
            ],
        ],
        'image' => [
            'config' => [
                'overrideChildTca' => [
                    'columns' => [
                        'crop' => [
                            'config' => [
                                'cropVariants' => [
                                    'default' => [
                                        'title' => 'LLL:EXT:site_t3demo/Resources/Private/Language/locallang_db.xlf:cropvariants.default.label',
                                        'allowedAspectRatios' => [
                                            '2.83:1' => [
                                                'title' => 'LLL:EXT:site_t3demo/Resources/Private/Language/locallang_db.xlf:CType.mainteaser.crop.default.title',
                                                'value' => 2.83,
                                            ],
                                        ],
                                        'selectedRatio' => '2.83:1',
                                    ],
                                    'desktop' => [
                                        'title' => 'LLL:EXT:site_t3demo/Resources/Private/Language/locallang_db.xlf:cropvariants.desktop.label',
                                        'allowedAspectRatios' => [
                                            '1.07:1' => [
                                                'title' => 'LLL:EXT:site_t3demo/Resources/Private/Language/locallang_db.xlf:CType.mainteaser.crop.desktop.title',
                                                'value' => 1.07,
                                            ],
                                        ],
                                        'selectedRatio' => '1.07:1',
                                    ],
                                    'desktop-xl' => [
                                        'title' => 'LLL:EXT:site_t3demo/Resources/Private/Language/locallang_db.xlf:cropvariants.desktop-xl.label',
                                        'allowedAspectRatios' => [
                                            '1.81:1' => [
                                                'title' => 'LLL:EXT:site_t3demo/Resources/Private/Language/locallang_db.xlf:CType.mainteaser.crop.desktop-xl.title',
                                                'value' => 1.81,
                                            ],
                                        ],
                                        'selectedRatio' => '1.81:1',
                                    ],
                                ],
                            ],
                        ],
                    ],
                    'types' => $GLOBALS['TCA']['sys_file_reference']['defaultTypeConfiguration']['nolinkImageoverlay'],
                ],
            ],
        ],
    ],
];
