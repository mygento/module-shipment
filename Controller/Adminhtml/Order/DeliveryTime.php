<?php

/**
 * @author Mygento Team
 * @copyright 2016-2020 Mygento (https://www.mygento.ru)
 * @package Mygento_Shipment
 */

namespace Mygento\Shipment\Controller\Adminhtml\Order;

class DeliveryTime extends \Magento\Backend\App\Action
{
    /**
     * @var \Magento\Framework\Controller\Result\JsonFactory
     */
    private $jsonFactory;

    /**
     * @var \Magento\Sales\Api\OrderRepositoryInterface
     */
    private $repo;

    /**
     * @param \Magento\Sales\Api\OrderRepositoryInterface $repo
     * @param \Magento\Framework\Controller\Result\JsonFactory $jsonFactory
     * @param \Magento\Backend\App\Action\Context $context
     */
    public function __construct(
        \Magento\Sales\Api\OrderRepositoryInterface $repo,
        \Magento\Framework\Controller\Result\JsonFactory $jsonFactory,
        \Magento\Backend\App\Action\Context $context
    ) {
        parent::__construct($context);
        $this->repo = $repo;
        $this->jsonFactory = $jsonFactory;
    }

    /**
     * @inheritDoc
     */
    public function execute()
    {
        /** @var \Magento\Framework\Controller\Result\Json $resultJson */
        $resultJson = $this->jsonFactory->create();

        if (!($this->getRequest()->getParam('isAjax'))
            || !$this->getRequest()->getParam('from')
            || !$this->getRequest()->getParam('to')) {
            return $resultJson->setData([
                'messages' => [__('Please correct the data sent.')],
                'error' => true,
            ]);
        }
        $entityId = $this->getRequest()->getParam('id');

        $deliveryFrom = max(0, min(24, (int) $this->getRequest()->getParam('from')));
        $deliveryTo = max(0, min(24, (int) $this->getRequest()->getParam('to')));
        if ($deliveryTo < $deliveryFrom) {
            $deliveryTo = $deliveryFrom;
        }

        $from = str_pad($deliveryFrom, 2, '0', STR_PAD_LEFT) . ':00';
        $to = str_pad($deliveryTo, 2, '0', STR_PAD_LEFT) . ':00';

        $messages = [];
        $error = false;

        try {
            $order = $this->repo->get($entityId);
            $order->getShippingAddress()->getExtensionAttributes()->setDeliveryTimeFrom($from);
            $order->getShippingAddress()->setDeliveryTimeFrom($from);
            $order->getShippingAddress()->getExtensionAttributes()->setDeliveryTimeTo($to);
            $order->getShippingAddress()->setDeliveryTimeTo($to);
            $this->repo->save($order);
        } catch (\Magento\Framework\Exception\NoSuchEntityException $e) {
            unset($e);
            $messages[] = $entityId . ' -> ' . __('Not found');
            $error = true;
        } catch (\Exception $e) {
            unset($e);
            $messages[] = $entityId . ' -> ' . __('Save Problem');
            $error = true;
        }

        return $resultJson->setData([
            'content' => $from . ' - ' . $to,
            'messages' => $messages,
            'error' => $error,
        ]);
    }
}
