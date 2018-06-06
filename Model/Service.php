<?php

/**
 * @author Mygento Team
 * @copyright 2016-2018 Mygento (https://www.mygento.ru)
 * @package Mygento_Shipment
 */

namespace Mygento\Shipment\Model;

use Mygento\Shipment\Api\Service\CalculateInterface;
use Mygento\Shipment\Api\Service\OrderInterface;

class Service implements CalculateInterface, OrderInterface
{
    public function calculateDeliveryCost(array $params): array
    {
    }

    public function orderCancel($orderId)
    {
    }

    public function orderCreate(\Magento\Sales\Model\Order $order, $data = [])
    {
    }
}
