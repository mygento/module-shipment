<?php

/**
 * @author Mygento Team
 * @copyright 2016-2019 Mygento (https://www.mygento.ru)
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
}
