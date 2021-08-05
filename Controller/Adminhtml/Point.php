<?php

/**
 * @author Mygento Team
 * @copyright 2016-2021 Mygento (https://www.mygento.ru)
 * @package Mygento_Shipment
 */

namespace Mygento\Shipment\Controller\Adminhtml;

abstract class Point extends \Magento\Backend\App\Action
{
    /**
     * Authorization level
     *
     * @see _isAllowed()
     */
    const ADMIN_RESOURCE = 'Mygento_Shipment::point';

    /**
     * Core registry
     *
     * @var \Magento\Framework\Registry
     */
    protected $coreRegistry;

    /**
     * Point repository
     *
     * @var \Mygento\Shipment\Api\PointRepositoryInterface
     */
    protected $repository;

    /**
     * @param \Mygento\Shipment\Api\PointRepositoryInterface $repository
     * @param \Magento\Framework\Registry $coreRegistry
     * @param \Magento\Backend\App\Action\Context $context
     */
    public function __construct(
        \Mygento\Shipment\Api\PointRepositoryInterface $repository,
        \Magento\Framework\Registry $coreRegistry,
        \Magento\Backend\App\Action\Context $context
    ) {
        parent::__construct($context);
        $this->repository = $repository;
        $this->coreRegistry = $coreRegistry;
    }

    /**
     * Init page
     *
     * @param \Magento\Backend\Model\View\Result\Page $resultPage
     * @return \Magento\Backend\Model\View\Result\Page
     */
    protected function initPage($resultPage)
    {
        $resultPage->setActiveMenu('Mygento_Shipment::point');

        return $resultPage;
    }
}
