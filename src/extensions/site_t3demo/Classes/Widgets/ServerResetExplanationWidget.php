<?php

declare(strict_types=1);

namespace B13\SiteT3demo\Widgets;

use TYPO3\CMS\Dashboard\Widgets\WidgetConfigurationInterface;
use TYPO3\CMS\Dashboard\Widgets\WidgetInterface;
use TYPO3\CMS\Fluid\View\StandaloneView;

class ServerResetExplanationWidget implements WidgetInterface
{
    /**
     * @var WidgetConfigurationInterface
     */
    private $configuration;

    /**
     * @var StandaloneView
     */
    private $view;

    /**
     * @var array
     */
    private $options;

    public function __construct(
        WidgetConfigurationInterface $configuration,
        StandaloneView $view,
        array $options = []
    ) {
        $this->configuration = $configuration;
        $this->view = $view;
        $this->options = $options;
    }

    public function renderWidgetContent(): string
    {
        $this->view->setTemplate('Widget/ServerResetExplanation');
        $this->view->assignMultiple([
            'options' => $this->options,
            'configuration' => $this->configuration,
        ]);
        return $this->view->render();
    }
}
