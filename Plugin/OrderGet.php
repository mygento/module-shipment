<?php

/**
 * @author Mygento Team
 * @copyright 2016-2020 Mygento (https://www.mygento.ru)
 * @package Mygento_Shipment
 */

namespace Mygento\Shipment\Plugin;

class OrderGet
{
    /**
     * @param \Magento\Sales\Api\OrderRepositoryInterface $subject
     * @param \Magento\Sales\Api\Data\OrderInterface $result
     *
     * @return \Magento\Sales\Api\Data\OrderInterface
     *
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function afterGet(
        \Magento\Sales\Api\OrderRepositoryInterface $subject,
        \Magento\Sales\Api\Data\OrderInterface $result
    ) {
        return $this->getOrderAddress($result);
    }

    /**
     * @param \Magento\Sales\Api\OrderRepositoryInterface $subject
     * @param \Magento\Sales\Model\ResourceModel\Order\Collection $resultOrder
     * @return \Magento\Sales\Model\ResourceModel\Order\Collection
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function afterGetList(
        \Magento\Sales\Api\OrderRepositoryInterface $subject,
        \Magento\Sales\Model\ResourceModel\Order\Collection $resultOrder
    ) {
        /** @var \Magento\Sales\Api\Data\OrderInterface $order */
        foreach ($resultOrder->getItems() as $order) {
            $this->afterGet($subject, $order);
        }

        return $resultOrder;
    }

    /**
     * @param \Magento\Sales\Api\Data\OrderInterface $order
     * @return \Magento\Sales\Api\Data\OrderInterface
     */
    private function getOrderAddress(\Magento\Sales\Api\Data\OrderInterface $order)
    {
        $shippingAddress = $order->getShippingAddress();
        $shippingAddress->getExtensionAttributes()->setDeliveryEstimate($shippingAddress->getDeliveryEstimate());
        $shippingAddress->getExtensionAttributes()->setDeliveryDate($shippingAddress->getDeliveryDate());
        $shippingAddress->getExtensionAttributes()->setDeliveryTimeFrom($shippingAddress->getDeliveryTimeFrom());
        $shippingAddress->getExtensionAttributes()->setDeliveryTimeTo($shippingAddress->getDeliveryTimeTo());
        $shippingAddress->getExtensionAttributes()->setShipmentDate($shippingAddress->getShipmentDate());

        return $order;
    }
}
