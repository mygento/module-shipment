<?php

/**
 * @author Mygento Team
 * @copyright 2016-2021 Mygento (https://www.mygento.ru)
 * @package Mygento_Shipment
 */

namespace Mygento\Shipment\Api;

use Mygento\Shipment\Model\AbstractService;

interface CarrierManagerInterface
{
    public function getCarrierCodes(): array;

    public function getCarrierServiceInstance(string $carrier): ?AbstractService;
}
