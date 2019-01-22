<?php

/**
 * @author Mygento Team
 * @copyright 2016-2019 Mygento (https://www.mygento.ru)
 * @package Mygento_Shipment
 */

namespace Mygento\Shipment\Api\Service;

interface CalculateInterface
{
    /**
     * @param array $params
     * @return array
     */
    public function calculateDeliveryCost(array $params): array;
}
