<?php

/**
 * @author Mygento Team
 * @copyright 2016-2025 Mygento (https://www.mygento.com)
 * @package Mygento_Shipment
 */

namespace Mygento\Shipment\Controller\Adminhtml\Point;

use Magento\Backend\App\Action\Context;
use Magento\Framework\App\Request\DataPersistorInterface;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\Registry;
use Magento\Framework\View\Result\PageFactory;
use Mygento\Shipment\Api\PointRepositoryInterface;
use Mygento\Shipment\Controller\Adminhtml\Point;

class Index extends Point
{
    public function __construct(
        private readonly PageFactory $resultPageFactory,
        private readonly DataPersistorInterface $dataPersistor,
        PointRepositoryInterface $repository,
        Registry $coreRegistry,
        Context $context,
    ) {
        parent::__construct($repository, $coreRegistry, $context);
    }

    /**
     * Index action
     */
    public function execute(): ResultInterface
    {
        /** @var \Magento\Backend\Model\View\Result\Page $resultPage */
        $resultPage = $this->resultPageFactory->create();
        $resultPage
            ->setActiveMenu('Mygento_Shipment::point')
            ->getConfig()
            ->getTitle()->prepend(__('Point')->render());

        $this->dataPersistor->clear('shipment_point');

        return $resultPage;
    }
}
