<?php

namespace B13\SiteT3demo\Backend\Services;

use Psr\Http\Message\ServerRequestInterface;
use TYPO3\CMS\Backend\Utility\BackendUtility;
use TYPO3\CMS\Core\Type\Bitmask\Permission;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Fluid\View\StandaloneView;

class InfoHeaderService
{
    private ServerRequestInterface $request;

    public function __construct(ServerRequestInterface $request)
    {
        $this->request = $request;
    }

    public function getInfo(): string
    {
        $pageUid = (int)($this->request->getParsedBody()['id'] ?? $this->request->getQueryParams()['id'] ?? 0);
        $pageInfo = BackendUtility::readPageAccess($pageUid, $GLOBALS['BE_USER']->getPagePermsClause(Permission::PAGE_SHOW));

        // Exit if this page does not have any notes of interest
        // If there is no header we do not add anything
        if (empty($pageInfo['infotext_header'])) {
            $content = '';
        } else {
            $view = GeneralUtility::makeInstance(StandaloneView::class);
            $view->setTemplatePathAndFilename('EXT:site_t3demo/Resources/Private/Backend/Templates/PageLayout/Header.html');
            $view->assignMultiple([
                'data' => $pageInfo,
                'pageUid' => $pageUid,
            ]);

            $content = $view->render();
        }

        return $content;
    }
}
