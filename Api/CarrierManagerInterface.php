<?php

/**
 * @author Mygento Team
 * @copyright 2016-2025 Mygento (https://www.mygento.com)
 * @package Mygento_Shipment
 */

namespace Mygento\Shipment\Api;

use Mygento\Shipment\Model\AbstractService;

interface CarrierManagerInterface
{
    public function getCarrierCodes(): array;

    public function getCarrierServiceInstance(string $carrier): ?AbstractService;
}
