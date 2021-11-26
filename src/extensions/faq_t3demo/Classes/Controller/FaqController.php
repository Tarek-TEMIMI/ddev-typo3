<?php

declare(strict_types=1);

namespace B13\FaqT3demo\Controller;

/*
 * This file is part of TYPO3 CMS-based extension "faq_t3demo" by b13.
 *
 * It is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License, either version 2
 * of the License, or any later version.
 */

use B13\FaqT3demo\RecordList\DatabaseRecordList;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use TYPO3\CMS\Backend\Template\ModuleTemplate;
use TYPO3\CMS\Backend\Utility\BackendUtility;
use TYPO3\CMS\Core\Authentication\BackendUserAuthentication;
use TYPO3\CMS\Core\Configuration\ExtensionConfiguration;
use TYPO3\CMS\Core\Http\HtmlResponse;
use TYPO3\CMS\Core\Localization\LanguageService;
use TYPO3\CMS\Core\Messaging\FlashMessage;
use TYPO3\CMS\Core\Messaging\FlashMessageQueue;
use TYPO3\CMS\Core\Messaging\FlashMessageService;
use TYPO3\CMS\Core\Page\PageRenderer;
use TYPO3\CMS\Core\Type\Bitmask\Permission;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Fluid\View\StandaloneView;
use TYPO3Fluid\Fluid\View\ViewInterface;

class FaqController
{
    private const RECORDS_TO_DISPLAY = 100;

    protected ModuleTemplate $moduleTemplate;

    /**
     * @var ViewInterface
     */
    protected $view;

    /**
     * @var mixed[]
     */
    protected $extensionConfiguration;

    /**
     * @var FlashMessageQueue
     */
    protected FlashMessageQueue $flashMessageQueue;

    public function __construct(
        ExtensionConfiguration $extensionConfiguration,
        PageRenderer $pageRenderer,
        FlashMessageService $flashMessageService
    ) {
        $this->extensionConfiguration = $extensionConfiguration->get('faq_t3demo');
        $this->moduleTemplate = GeneralUtility::makeInstance(ModuleTemplate::class);
        $this->flashMessageQueue = $flashMessageService->getMessageQueueByIdentifier();
        $this->getLanguageService()->includeLLFile('EXT:core/Resources/Private/Language/locallang_mod_web_list.xlf');
        $this->getLanguageService()->includeLLFile('EXT:faq_t3demo/Resources/Private/Language/locallang_module.xlf');
        $pageRenderer->addInlineLanguageLabelFile('EXT:core/Resources/Private/Language/locallang_mod_web_list.xlf');
        $pageRenderer->loadRequireJsModule('TYPO3/CMS/Recordlist/Recordlist');
        $pageRenderer->loadRequireJsModule('TYPO3/CMS/Backend/ActionDispatcher');
        $pageRenderer->loadRequireJsModule('TYPO3/CMS/Backend/ContextMenu');
    }

    protected function getDatabaseRecordList(string $filter): DatabaseRecordList
    {
        $pageinfo = BackendUtility::readPageAccess(
            $this->extensionConfiguration['pid'],
            $this->getBackendUser()->getPagePermsClause(Permission::PAGE_SHOW)
        );
        $dblist = GeneralUtility::makeInstance(DatabaseRecordList::class);
        $dblist->pageRow = $pageinfo;
        $dblist->calcPerms = new Permission($this->getBackendUser()->calcPerms($pageinfo));
        $dblist->displayColumnSelector = false;
        $dblist->displayRecordDownload = false;
        $dblist->start($this->extensionConfiguration['pid'], 'tx_faqt3demo_faq', (int)GeneralUtility::_GP('pointer'), $filter, 0, self::RECORDS_TO_DISPLAY);
        $dblist->setModuleData(['bigControlPanel' => true]);
        return $dblist;
    }

    public function handleRequest(ServerRequestInterface $request): ResponseInterface
    {
        $this->initializeView();
        $this->listAction($request);
        $this->moduleTemplate->setContent($this->view->render());
        return new HtmlResponse($this->moduleTemplate->renderContent());
    }

    protected function listAction(ServerRequestInterface $request): void
    {
        $filter = $request->getQueryParams()['filter'] ?? $request->getParsedBody()['filter'] ?? '';
        $dblist = $this->getDatabaseRecordList($filter);
        if ($dblist->getTotalItems('tx_faqt3demo_faq', $this->extensionConfiguration['pid']) === 0) {
            if ($filter === '') {
                $this->flashMessageQueue->enqueue(
                    new FlashMessage(
                        $this->getLanguageService()->getLL('flashMessage.no_records.created'),
                        $this->getLanguageService()->getLL('flashMessage.no_records.title'),
                        FlashMessage::INFO
                    )
                );
            } else {
                $this->flashMessageQueue->enqueue(
                    new FlashMessage(
                        sprintf($this->getLanguageService()->getLL('flashMessage.no_records.found'), $filter),
                        $this->getLanguageService()->getLL('flashMessage.no_records.title'),
                        FlashMessage::INFO
                    )
                );
            }
        }
        $this->view->assign('dblist', $dblist->generateList());
        $this->view->assign('filter', $filter);
        $this->view->assign('extensionConfiguration', $this->extensionConfiguration);
    }

    protected function initializeView(): void
    {
        $this->view = GeneralUtility::makeInstance(StandaloneView::class);
        $this->view->setTemplate('List');
        $this->view->setTemplateRootPaths(['EXT:faq_t3demo/Resources/Private/Templates/Faq']);
        $this->view->setLayoutRootPaths(['EXT:faq_t3demo/Resources/Private/Layouts']);
    }

    protected function getLanguageService(): LanguageService
    {
        return $GLOBALS['LANG'];
    }

    protected function getBackendUser(): BackendUserAuthentication
    {
        return $GLOBALS['BE_USER'];
    }
}
