<?php

defined('TYPO3_MODE') or die('Access denied!');

(function () {
    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addModule(
        'web',
        'faq',
        '',
        '',
        [
            'routeTarget' => \B13\FaqT3demo\Controller\FaqController::class . '::handleRequest',
            'access' => 'group,user',
            'name' => 'web_faq',
            'icon' => 'EXT:faq_t3demo/Resources/Public/Icons/Module.svg',
            'labels' => 'LLL:EXT:faq_t3demo/Resources/Private/Language/locallang_module.xlf',
            'navigationComponentId' => '',
            'inheritNavigationComponentFromMainModule' => false,
        ]
    );
})();
