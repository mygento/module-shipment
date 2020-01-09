<?php

/**
 * @author Mygento Team
 * @copyright 2016-2019 Mygento (https://www.mygento.ru)
 * @package Mygento_Shipment
 */

namespace Mygento\Shipment\Api\Service;

use Mygento\Shipment\Api\Data\CalculateRequestInterface;

interface CalculateInterface extends BaseInterface
{
    /**
     * @param \Mygento\Shipment\Api\Data\CalculateRequestInterface $request
     * @return \Mygento\Shipment\Api\Data\CalculateResultInterface[]
     */
    public function calculateDeliveryCost(CalculateRequestInterface $request): array;

    /**
     * @return float
     */
    public function getWeightRatio(): float;

    /**
     * @return float
     */
    public function getSizeRatio(): float;
}
