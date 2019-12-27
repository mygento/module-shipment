<?php

/**
 * @author Mygento Team
 * @copyright 2016-2019 Mygento (https://www.mygento.ru)
 * @package Mygento_Shipment
 */

namespace Mygento\Shipment\Api\Service;

use Mygento\Shipment\Api\Data\CalculateRequestInterface;

interface CalculateInterface
{
    /**
     * @param \Mygento\Shipment\Api\Data\CalculateRequestInterface $request
     * @return array
     */
    public function calculateDeliveryCost(CalculateRequestInterface $request): array;
}
