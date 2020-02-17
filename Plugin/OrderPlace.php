<?php

/**
 * @author Mygento Team
 * @copyright 2016-2020 Mygento (https://www.mygento.ru)
 * @package Mygento_Shipment
 */

namespace Mygento\Shipment\Plugin;

use Magento\Sales\Api\Data\OrderInterface;
use Magento\Sales\Model\Service\OrderService;

class OrderPlace
{
    /**
     * @param OrderService $subject
     * @param OrderInterface $order
     * @return array
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function beforePlace(OrderService $subject, OrderInterface $order)
    {
        return [$order];
    }
}
