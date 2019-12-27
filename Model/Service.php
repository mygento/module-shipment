<?php

/**
 * @author Mygento Team
 * @copyright 2016-2019 Mygento (https://www.mygento.ru)
 * @package Mygento_Shipment
 */

namespace Mygento\Shipment\Model;

use Mygento\Shipment\Api\Data\CalculateRequestInterface;
use Mygento\Shipment\Api\Service\CalculateInterface;
use Mygento\Shipment\Api\Service\OrderInterface;

class Service implements CalculateInterface, OrderInterface
{
    /**
     * @param CalculateRequestInterface $request
     * @return array
     */
    public function calculateDeliveryCost(CalculateRequestInterface $request): array
    {
        return [];
    }

    /**
     * @param int|string $orderId
     */
    public function orderCancel($orderId)
    {
    }

    /**
     * @param \Magento\Sales\Model\Order $order
     * @param array $data
     */
    public function orderCreate(\Magento\Sales\Model\Order $order, $data = [])
    {
    }
}
