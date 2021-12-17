<?php

/**
 * @author Mygento Team
 * @copyright 2016-2021 Mygento (https://www.mygento.ru)
 * @package Mygento_Shipment
 */

namespace Mygento\Shipment\Api\Service;

interface MarkingInterface
{
    public function updateCarrierMarking(\Magento\Sales\Model\Order $order);
}
