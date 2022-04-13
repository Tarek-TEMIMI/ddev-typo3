<?php

declare(strict_types=1);

namespace B13\DemoLogin\LoginProvider;

/*
 * This file is part of TYPO3 CMS-based extension "demologin" by b13.
 *
 * It is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License, either version 2
 * of the License, or any later version.
 */

use TYPO3\CMS\Backend\Controller\LoginController;
use TYPO3\CMS\Backend\LoginProvider\LoginProviderInterface;
use TYPO3\CMS\Core\Database\Connection;
use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Database\Query\QueryBuilder;
use TYPO3\CMS\Core\Page\PageRenderer;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Persistence\QueryInterface;
use TYPO3\CMS\Fluid\View\StandaloneView;

class DemoLoginProvider implements LoginProviderInterface
{
    protected QueryBuilder $queryBuilder;

    protected array $allowedUserGroups = [2, 3];

    public function __construct()
    {
        $this->queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)->getQueryBuilderForTable('be_groups');
    }

    public function render(StandaloneView $view, PageRenderer $pageRenderer, LoginController $loginController): void
    {
        $view->setTemplatePathAndFilename('EXT:demologin/Resources/Private/Templates/DemoLogin.html');
        $view->assign('userGroups', $this->getPossibleUserGroups());
    }

    protected function getPossibleUserGroups(): array
    {
        return $this->queryBuilder
            ->select('*')
            ->from('be_groups')
            ->where(
                $this->queryBuilder->expr()->in('uid', $this->queryBuilder->createNamedParameter($this->allowedUserGroups, Connection::PARAM_INT_ARRAY))
            )
            ->orderBy('uid', QueryInterface::ORDER_DESCENDING)
            ->executeQuery()
            ->fetchAllAssociative();
    }
}
