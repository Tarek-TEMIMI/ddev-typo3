<?php

use B13\SiteT3demo\PageConfiguration;
use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;

ExtensionManagementUtility::addTCAcolumns('pages', [
    'infotext_header' => [
        'l10n_mode' => 'exclude',
        'l10n_display' => 'defaultAsReadonly',
        'label' => 'LLL:EXT:site_t3demo/Resources/Private/Language/locallang_db.xlf:pages.infotext_header',
        'exclude' => 1,
        'config' => [
            'type' => 'input',
            'size' => 50,
            'max' => 255,
        ],
    ],
    'infotext' => [
        'l10n_mode' => 'exclude',
        'l10n_display' => 'defaultAsReadonly',
        'label' => 'LLL:EXT:site_t3demo/Resources/Private/Language/locallang_db.xlf:pages.infotext',
        'exclude' => 1,
        'description' => 'LLL:EXT:site_t3demo/Resources/Private/Language/locallang_db.xlf:pages.infotext.description',
        'config' => [
            'type' => 'text',
            'cols' => 80,
            'rows' => 15,
            'softref' => 'typolink_tag,email[subst],url',
            'enableRichtext' => true, // we can safely enable RTE for this field, there's no plan to use this as a plain text field
        ],
    ],
]);

$GLOBALS['TCA']['pages']['palettes']['infotext'] = [
    'label' => 'LLL:EXT:site_t3demo/Resources/Private/Language/locallang_db.xlf:pages.palettes.infotext.label',
    'showitem' => 'infotext_header,
        --linebreak--,
        infotext'
];

ExtensionManagementUtility::addToAllTCAtypes(
    'pages',
    '--div--;LLL:EXT:site_t3demo/Resources/Private/Language/locallang_db.xlf:pages.div.infotext,
                  --palette--;;infotext'
);

$doktypesToAdd = [
    ['apple', PageConfiguration::DOKTYPE_APPLE],
    ['recipe', PageConfiguration::DOKTYPE_RECIPE],
    ['startpage', PageConfiguration::DOKTYPE_STARTPAGE],
    ['overview', PageConfiguration::DOKTYPE_OVERVIEW],
    ['faqpage', PageConfiguration::DOKTYPE_FAQPAGE],
];

foreach ($doktypesToAdd as $item) {
    ExtensionManagementUtility::addTcaSelectItem(
        'pages',
        'doktype',
        [
            'LLL:EXT:site_t3demo/Resources/Private/Language/locallang_db.xlf:pages.doktype.' . $item[0],
            $item[1],
            '',
            $item[2] ?? 'default'
        ]
    );
    $GLOBALS['TCA']['pages']['ctrl']['typeicon_classes'][$item[1]] = 'apps-pagetree-page-default';
    $GLOBALS['TCA']['pages']['ctrl']['typeicon_classes'][$item[1] . '-hideinmenu'] = 'apps-pagetree-page-hideinmenu';
    $GLOBALS['TCA']['pages']['ctrl']['typeicon_classes'][$item[1] . '-root'] = 'apps-pagetree-page-domain';
}

$doktypesWithCustomIcons = [
    ['apple', PageConfiguration::DOKTYPE_APPLE],
    ['recipe', PageConfiguration::DOKTYPE_RECIPE],
    ['overview', PageConfiguration::DOKTYPE_OVERVIEW],
];

foreach ($doktypesWithCustomIcons as $item) {
    $GLOBALS['TCA']['pages']['ctrl']['typeicon_classes'][$item[1]] = 'apps-pagetree-page-' . $item[0];
}

// we use the doktype configuration for default page "1" as a basis for our customization
// this is needed so we can manipulate the showitem configuration using \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addToAllTCAtypes
foreach ($doktypesToAdd as $doktype) {
    $GLOBALS['TCA']['pages']['types'][$doktype[1]]['showitem'] = $GLOBALS['TCA']['pages']['types'][1]['showitem'];
}

// remove "Media" and "Abstraact" palettes from recipe and apple pages
foreach ([
    (string)PageConfiguration::DOKTYPE_APPLE,
    (string)PageConfiguration::DOKTYPE_RECIPE
] as $doktype) {
    $GLOBALS['TCA']['pages']['types'][$doktype]['showitem'] = str_replace('--palette--;;media,', '', $GLOBALS['TCA']['pages']['types'][$doktype]['showitem']);
    $GLOBALS['TCA']['pages']['types'][$doktype]['showitem'] = str_replace('--palette--;;abstract,', '', $GLOBALS['TCA']['pages']['types'][$doktype]['showitem']);
}

// remove "Media" from all doktypes not using the field
foreach ([
             (string)PageConfiguration::DOKTYPE_CONTENTPAGE,
             (string)PageConfiguration::DOKTYPE_STARTPAGE,
             (string)PageConfiguration::DOKTYPE_OVERVIEW
         ] as $doktype) {
    $GLOBALS['TCA']['pages']['types'][$doktype]['showitem'] = str_replace('--palette--;;media,', '', $GLOBALS['TCA']['pages']['types'][$doktype]['showitem']);
}

// add a palette for "teaser data"
$GLOBALS['TCA']['pages']['palettes']['teaserdata'] = [
    'label' => 'LLL:EXT:site_t3demo/Resources/Private/Language/locallang_db.xlf:pages.palettes.teaserdata.label',
    'showitem' => 'abstract;LLL:EXT:site_t3demo/Resources/Private/Language/locallang_db.xlf:pages.abstract.label,
        --linebreak--,
        media;LLL:EXT:site_t3demo/Resources/Private/Language/locallang_db.xlf:pages.media.label'
];

// add teaser palette to page properties for apples and recipes
foreach ([
             (string)PageConfiguration::DOKTYPE_APPLE,
             (string)PageConfiguration::DOKTYPE_RECIPE
         ] as $doktype) {
    ExtensionManagementUtility::addToAllTCAtypes(
        'pages',
        '--palette--;;teaserdata',
        $doktype,
        'after:subtitle'
    );
}

// add image crop variant for teaser images (3:2) for field media
$GLOBALS['TCA']['pages']['columns']['media']['config']['overrideChildTca']['columns']['crop']['config'] = [
    'cropVariants' => [
        'default' => [
            'title' => 'LLL:EXT:site_t3demo/Resources/Private/Language/locallang_db.xlf:pages.media.crop.default.label',
            'allowedAspectRatios' => [
                '3:2' => [
                    'title' => 'LLL:EXT:site_t3demo/Resources/Private/Language/locallang_db.xlf:pages.media.crop.default.title',
                    'value' => 1.5
                ],
            ],
            'selectedRatio' => '3:2',
        ],
    ]
];

$GLOBALS['TCA']['pages']['columns']['media']['config']['overrideChildTca']['types'] = $GLOBALS['TCA']['sys_file_reference']['defaultTypeConfiguration']['cropImageoverlay'];
