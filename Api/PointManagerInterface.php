<?php

/**
 * @author Mygento Team
 * @copyright 2016-2020 Mygento (https://www.mygento.ru)
 * @package Mygento_Shipment
 */

namespace Mygento\Shipment\Api;

interface PointManagerInterface
{
    /**
     * Update all points
     */
    public function updatePoints();

    /**
     * @return \Mygento\Shipment\Api\Data\PointInterface
     */
    public function getPoint(): Data\PointInterface;

    /**
     * @param string $carrier
     */
    public function cleanByCarrier(string $carrier);

    /**
     * @return string
     */
    public function getTable(): string;

    /**
     * @param string $carrier
     * @param string $city
     * @return \Mygento\Shipment\Api\Data\PointInterface[]
     */
    public function getPointsByCity(string $carrier, string $city);
}
