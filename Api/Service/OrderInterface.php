<?php

/**
 * @author Mygento Team
 * @copyright 2016-2020 Mygento (https://www.mygento.ru)
 * @package Mygento_Shipment
 */

namespace Mygento\Shipment\Api\Service;

interface OrderInterface
{
    /**
     * @param \Magento\Sales\Model\Order $order
     * @param array $data
     */
    public function orderCreate(\Magento\Sales\Model\Order $order, $data = []);

    /**
     * @param int|string $orderId
     */
    public function orderCancel($orderId);

    /**
     * Добавление кода отслеживания
     *
     * @param \Magento\Sales\Model\Order $order
     * @param string $trackingCode
     * @param bool $notify
     *
     * @throws \Magento\Framework\Exception\CouldNotSaveException
     */
    public function setTracking(
        \Magento\Sales\Model\Order $order,
        string $trackingCode,
        bool $notify = false
    );
}
