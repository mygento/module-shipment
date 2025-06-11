<?php

/**
 * @author Mygento Team
 * @copyright 2016-2025 Mygento (https://www.mygento.com)
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
