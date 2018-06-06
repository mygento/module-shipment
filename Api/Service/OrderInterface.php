<?php

/**
 * @author Mygento Team
 * @copyright 2016-2018 Mygento (https://www.mygento.ru)
 * @package Mygento_Shipment
 */

namespace Mygento\Shipment\Api\Service;

interface OrderInterface
{
    public function orderCreate(\Magento\Sales\Model\Order $order, $data = []);

    public function orderCancel($orderId);
}
