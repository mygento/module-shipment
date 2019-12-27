<?php

/**
 * @author Mygento Team
 * @copyright 2016-2019 Mygento (https://www.mygento.ru)
 * @package Mygento_Shipment
 */

namespace Mygento\Shipment\Model;

use Mygento\Shipment\Api\Service\CalculateInterface;
use Mygento\Shipment\Api\Service\OrderInterface;

abstract class AbstractService implements CalculateInterface, OrderInterface
{
    /**
     * @var \Mygento\Shipment\Model\Service
     */
    protected $baseService;

    /**
     * @param \Mygento\Shipment\Model\Service $service
     */
    public function __construct(
        \Mygento\Shipment\Model\Service $service
    ) {
        $this->baseService = $service;
    }
}
