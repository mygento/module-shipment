<?php

/**
 * @author Mygento Team
 * @copyright 2016-2021 Mygento (https://www.mygento.ru)
 * @package Mygento_Shipment
 */

namespace Mygento\Shipment\Api\Service;

interface OrderInterface
{
    /**
     * @param \Magento\Sales\Model\Order $order
     * @param array $data
     */
    public function createOrder(\Magento\Sales\Model\Order $order, $data = []);

    /**
     * @param int|string $orderId
     */
    public function cancelOrder($orderId);

    /**
     * @param \Magento\Sales\Model\Order $order
     */
    public function updateOrderStatus(\Magento\Sales\Model\Order $order);

    /**
     * Добавление кода отслеживания
     *
     * @param \Magento\Sales\Model\Order $order
     * @param string $carrierCode
     * @param string $trackingCode
     * @param bool $notify
     *
     * @throws \Magento\Framework\Exception\CouldNotSaveException
     */
    public function setTracking(
        \Magento\Sales\Model\Order $order,
        string $carrierCode,
        string $trackingCode,
        bool $notify = false
    );

    /**
     * @param string $trackingCode
     * @param string $carrier
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     * @return \Magento\Sales\Model\Order
     */
    public function findOrderByTracking(string $trackingCode, string $carrier);

    /**
     * @param \Magento\Sales\Model\Order $order
     * @param array $messages
     */
    public function failOrder($order, array $messages);

    /**
     * @param \Magento\Sales\Model\Order $order
     * @param string $status
     * @param string $comment
     */
    public function addOrderComment(
        \Magento\Sales\Model\Order $order,
        string $status,
        string $comment = ''
    );
}
