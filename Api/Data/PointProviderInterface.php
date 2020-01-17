<?php

/**
 * @author Mygento Team
 * @copyright 2016-2020 Mygento (https://www.mygento.ru)
 * @package Mygento_Shipment
 */

namespace Mygento\Shipment\Api\Data;

interface PointProviderInterface
{
    /**
     * @return string
     */
    public function getCode(): string;

    /**
     * Update carrier points
     */
    public function updatePoints();
}
