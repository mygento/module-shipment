<?php

/**
 * @author Mygento Team
 * @copyright 2016-2025 Mygento (https://www.mygento.com)
 * @package Mygento_Shipment
 */

namespace Mygento\Shipment\Api\Service;

interface MarkingInterface
{
    public function updateCarrierMarking(\Magento\Sales\Model\Order $order);
}
