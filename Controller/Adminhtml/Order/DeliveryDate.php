<?php

/**
 * @author Mygento Team
 * @copyright 2016-2021 Mygento (https://www.mygento.ru)
 * @package Mygento_Shipment
 */

namespace Mygento\Shipment\Controller\Adminhtml\Order;

class DeliveryDate extends \Magento\Backend\App\Action
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

        if (!($this->getRequest()->getParam('isAjax')) || !$this->getRequest()->getParam('field')) {
            return $resultJson->setData([
                'messages' => [__('Please correct the data sent.')],
                'error' => true,
            ]);
        }
        $entityId = $this->getRequest()->getParam('id');
        $deliveryDate = (string) $this->getRequest()->getParam('field');

        $messages = [];
        $error = false;

        try {
            $order = $this->repo->get($entityId);
            $order->getShippingAddress()->getExtensionAttributes()->setDeliveryDate($deliveryDate);
            $order->getShippingAddress()->setDeliveryDate($deliveryDate);
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
            'content' => $deliveryDate,
            'messages' => $messages,
            'error' => $error,
        ]);
    }
}
