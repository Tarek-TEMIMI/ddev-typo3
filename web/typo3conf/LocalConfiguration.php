<?php
return [
    'BE' => [
        'debug' => false,
        'explicitADmode' => 'explicitAllow',
        'installToolPassword' => getenv('TYPO3_INSTALLER_PASSWORD'),
        'loginSecurityLevel' => 'normal',
        'passwordHashing' => [
            'className' => 'TYPO3\\CMS\\Core\\Crypto\\PasswordHashing\\Argon2iPasswordHash',
            'options' => [],
        ],
    ],
    'DB' => [
        'Connections' => [
            'Default' => [
                'charset' => 'utf8mb4',
                'dbname' => getenv('TYPO3_DB_DATABASE'),
                'driver' => 'mysqli',
                'host' => getenv('TYPO3_DB_HOST'),
                'password' => getenv('TYPO3_DB_PASSWORD'),
                'port' => 3306,
                'tableoptions' => [
                    'charset' => 'utf8mb4',
                    'collate' => 'utf8mb4_unicode_ci',
                ],
                'user' => getenv('TYPO3_DB_USERNAME'),
            ],
        ],
    ],
    'EXTCONF' => [
        'lang' => [
            'availableLanguages' => [
                'de',
            ],
        ],
    ],
    'EXTENSIONS' => [
        'backend' => [
            'backendFavicon' => '',
            'backendLogo' => '',
            'loginBackgroundImage' => 'EXT:site_t3demo/Resources/Public/Backend/Login/login-background.svg',
            'loginFootnote' => 'TYPO3 made with ❤ by b13',
            'loginHighlightColor' => '#B11030',
            'loginLogo' => 'EXT:site_t3demo/Resources/Public/Assets/SVGs/logo.svg',
        ],
        'content_sync' => [
            'configuration' => [
                'databaseTables' => '',
                'excludeDatabaseTables' => 'sys_registry,sys_log,cache_*,tx_extensionmanager_domain_model_*,tx_contentsync_job,tx_scheduler_*',
                'syncFiles' => 'web/fileadmin',
            ],
            'sourceNode' => [
                'basePath' => '',
                'bin' => '',
                'connection' => '',
                'local' => '1',
            ],
            'targetNode' => [
                'basePath' => '',
                'bin' => '',
                'connection' => '',
                'local' => '0',
            ],
        ],
        'extensionmanager' => [
            'automaticInstallation' => '1',
            'offlineMode' => '0',
        ],
        'faq_t3demo' => [
            'pid' => 36,
        ],
        'scheduler' => [
            'maxLifetime' => '5',
            'showSampleTasks' => '0',
        ],
        'schema' => [
            'automaticBreadcrumbSchemaGeneration' => '1',
            'automaticWebPageSchemaGeneration' => '0',
            'embedMarkupInBodySection' => '1',
        ],
        'solr' => [
            'allowSelfSignedCertificates' => '0',
            'includeGlobalQParameterInCacheHash' => '0',
            'monitoringType' => '0',
            'pluginNamespaces' => 'tx_solr',
            'useConfigurationFromClosestTemplate' => '0',
            'useConfigurationMonitorTables' => '',
            'useConfigurationTrackRecordsOutsideSiteroot' => '1',
        ],
    ],
    'FE' => [
        'debug' => false,
        'disableNoCacheParameter' => true,
        'passwordHashing' => [
            'className' => 'TYPO3\\CMS\\Core\\Crypto\\PasswordHashing\\Argon2iPasswordHash',
            'options' => [],
        ],
    ],
    'GFX' => [
        'processor' => 'GraphicsMagick',
        'processor_allowTemporaryMasksAsPng' => false,
        'processor_colorspace' => 'RGB',
        'processor_effects' => false,
        'processor_enabled' => true,
        'processor_path' => '/usr/bin/',
        'processor_path_lzw' => '/usr/bin/',
    ],
    'LOG' => [
        'TYPO3' => [
            'CMS' => [
                'deprecations' => [
                    'writerConfiguration' => [
                        'notice' => [
                            'TYPO3\CMS\Core\Log\Writer\FileWriter' => [
                                'disabled' => true,
                            ],
                        ],
                    ],
                ],
            ],
        ],
        'writerConfiguration' => [
            'warning' => [
                'TYPO3\CMS\Core\Log\Writer\FileWriter' => ['disabled' => true]
                ],
            'error' => [
                'TYPO3\CMS\Core\Log\Writer\FileWriter' => ['disabled' => false]
            ],
        ],
    ],
    'MAIL' => [
        'transport' => 'sendmail',
        'transport_sendmail_command' => '/usr/sbin/sendmail -t -i',
        'transport_smtp_encrypt' => '',
        'transport_smtp_password' => '',
        'transport_smtp_server' => '',
        'transport_smtp_username' => '',
    ],
    'SYS' => [
        'belogErrorReporting' => 32765,
        'devIPmask' => '127.0.0.1,::1',
        'displayErrors' => -1,
        'encryptionKey' => getenv('TYPO3_ENCRYPTION_KEY'),
        'exceptionalErrors' => 4341,
        'features' => [
            'felogin.extbase' => true,
            'fluidBasedPageModule' => true,
            'rearrangedRedirectMiddlewares' => true,
            'unifiedPageTranslationHandling' => true,
        ],
        'sitename' => 'TYPO3 Demo',
        'systemMaintainers' => [
            1,
        ],
    ],
];
