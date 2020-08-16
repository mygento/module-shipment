<?php

/**
 * @author Mygento Team
 * @copyright 2016-2020 Mygento (https://www.mygento.ru)
 * @package Mygento_Shipment
 */

namespace Mygento\Shipment\Api\Service;

interface PointInterface extends OrderInterface
{
    /**
     * @return \Mygento\Shipment\Api\PointManagerInterface
     */
    public function getPointManager();

    /**
     * Update Points from Carrier
     */
    public function updatePoints();
}
