<?php

/**
 * @author Mygento Team
 * @copyright 2016-2021 Mygento (https://www.mygento.ru)
 * @package Mygento_Shipment
 */

namespace Mygento\Shipment\Api;

use Magento\Sales\Model\Order;

interface OrderStatusUpdaterInterface
{
    /**
     * @param Order $order
     * @param string $status
     * @param string $comment
     * @return mixed
     */
    public function update(Order $order, string $status, string $comment = '');
}
