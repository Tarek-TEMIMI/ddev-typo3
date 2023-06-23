<?php

declare(strict_types=1);

namespace B13\SiteT3demo\Backend\ToolbarItems;

/*
 * This file is part of TYPO3 CMS-extension site_t3demo by b13.
 *
 * It is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License, either version 2
 * of the License, or any later version.
 */

use B13\SiteT3demo\RegistryInterface;
use TYPO3\CMS\Backend\Toolbar\ToolbarItemInterface;
use TYPO3\CMS\Core\Core\Environment;
use TYPO3\CMS\Core\Page\PageRenderer;
use TYPO3\CMS\Core\Registry;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Fluid\View\StandaloneView;

class TimerToolbarItem implements ToolbarItemInterface
{
    protected Registry $registry;

    public function __construct(PageRenderer $pageRenderer, Registry $registry)
    {
        $pageRenderer->loadRequireJsModule('TYPO3/CMS/SiteT3demo/Backend/Timer');
        $this->registry = $registry;
    }

    public function checkAccess(): bool
    {
        return true;
    }

    public function getItem(): string
    {
        if ((string)Environment::getContext() === 'Production') {
            $nextSync = $this->registry->get(RegistryInterface::NAMESPACE, RegistryInterface::KEY);

            $view = GeneralUtility::makeInstance(StandaloneView::class);
            $view->setTemplatePathAndFilename('EXT:site_t3demo/Resources/Private/Templates/ToolbarItems/Timer.html');
            $view->assign('nextSync', $nextSync);

            return $view->render();
        }

        return '';
    }

    public function hasDropDown(): bool
    {
        return false;
    }

    public function getDropDown(): string
    {
        return '';
    }

    public function getAdditionalAttributes(): array
    {
        return [];
    }

    public function getIndex(): int
    {
        return 10;
    }
}
