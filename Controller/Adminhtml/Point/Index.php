<?php

/**
 * @author Mygento Team
 * @copyright 2016-2021 Mygento (https://www.mygento.ru)
 * @package Mygento_Shipment
 */

namespace Mygento\Shipment\Controller\Adminhtml\Point;

class Index extends \Mygento\Shipment\Controller\Adminhtml\Point
{
    /** @var \Magento\Framework\View\Result\PageFactory */
    private $resultPageFactory;

    /** @var \Magento\Framework\App\Request\DataPersistorInterface */
    private $dataPersistor;

    /**
     * @param \Magento\Framework\App\Request\DataPersistorInterface $dataPersistor
     * @param \Magento\Framework\View\Result\PageFactory $resultPageFactory
     * @param \Mygento\Shipment\Api\PointRepositoryInterface $repository
     * @param \Magento\Framework\Registry $coreRegistry
     * @param \Magento\Backend\App\Action\Context $context
     */
    public function __construct(
        \Magento\Framework\App\Request\DataPersistorInterface $dataPersistor,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory,
        \Mygento\Shipment\Api\PointRepositoryInterface $repository,
        \Magento\Framework\Registry $coreRegistry,
        \Magento\Backend\App\Action\Context $context
    ) {
        $this->resultPageFactory = $resultPageFactory;
        $this->dataPersistor = $dataPersistor;
        parent::__construct($repository, $coreRegistry, $context);
    }

    /**
     * Index action
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        /** @var \Magento\Backend\Model\View\Result\Page $resultPage */
        $resultPage = $this->resultPageFactory->create();
        $this->initPage($resultPage)->getConfig()->getTitle()->prepend(__('Point'));

        $this->dataPersistor->clear('shipment_point');

        return $resultPage;
    }
}
