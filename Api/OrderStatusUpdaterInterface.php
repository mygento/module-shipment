<?php

/**
 * @author Mygento Team
 * @copyright 2016-2021 Mygento (https://www.mygento.ru)
 * @package Mygento_Shipment
 */

namespace Mygento\Shipment\Api;

interface OrderStatusUpdaterInterface
{
    /**
     * @param \Magento\Sales\Model\Order $order
     * @param string $status
     * @param string $comment
     * @return mixed
     */
    public function update(\Magento\Sales\Model\Order $order, string $status, string $comment = '');
}
