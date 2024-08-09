<?php

/**
 * @author Mygento Team
 * @copyright 2016-2024 Mygento (https://www.mygento.ru)
 * @package Mygento_Shipment
 */

namespace Mygento\Shipment\Api\Service;

interface MarkingInterface
{
    public function updateCarrierMarking(\Magento\Sales\Model\Order $order);
}
