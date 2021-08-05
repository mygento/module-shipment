<?php

/**
 * @author Mygento Team
 * @copyright 2016-2021 Mygento (https://www.mygento.ru)
 * @package Mygento_Shipment
 */

namespace Mygento\Shipment\Api\Carrier;

interface TrackingInterface
{
    /**
     * @param string $trackNumber
     * @return array|\Magento\Shipping\Model\Tracking\Result\Status|null
     */
    public function getTrackingInfo($trackNumber);
}
