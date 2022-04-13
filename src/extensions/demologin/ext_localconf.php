<?php

defined('TYPO3_MODE') or die('Access denied.');

(function () {
    if ((string)\TYPO3\CMS\Core\Core\Environment::getContext() === 'Production') {
        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addService(
            'demologin',
            'auth',
            B13\DemoLogin\Service\DemoLoginAuthenticationService::class,
            [
                'title' => 'TYPO3 Demo Login',
                'description' => 'Demo Login authentication',
                'subtype' => 'getUserBE,authUserBE',
                'available' => true,
                'priority' => 90,
                'quality' => 90,
                'os' => '',
                'exec' => '',
                'className' => B13\DemoLogin\Service\DemoLoginAuthenticationService::class,
            ]
        );

        $GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['backend']['loginProviders'][1602851401] = [
            'provider' => \B13\DemoLogin\LoginProvider\DemoLoginProvider::class,
            'sorting' => 90,
            'icon-class' => 'fa-key',
            'label' => 'LLL:EXT:demologin/Resources/Private/Language/locallang.xlf:login.link',
        ];
    }
})();
