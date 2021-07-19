<?php

/**
 * @author Mygento Team
 * @copyright 2016-2020 Mygento (https://www.mygento.ru)
 * @package Mygento_Shipment
 */

namespace Mygento\Shipment\Model;

class CarrierManager implements \Mygento\Shipment\Api\CarrierManagerInterface
{
    /**
     * @var AbstractService[]
     */
    private $carriers;

    /**
     * @param array $carriers
     */
    public function __construct(array $carriers = [])
    {
        $this->carriers = $carriers;
    }

    /**
     * @return string[]
     */
    public function getCarrierCodes()
    {
        return array_keys($this->carriers);
    }

    /**
     * @param string $carrier
     * @return AbstractService|null
     */
    public function getCarrierServiceInstance(string $carrier): ?AbstractService
    {
        $instance = $this->carriers[$carrier] ?? null;

        if ($instance instanceof AbstractService) {
            return $instance;
        }

        return null;
    }
}
