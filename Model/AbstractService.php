<?php

/**
 * @author Mygento Team
 * @copyright 2016-2019 Mygento (https://www.mygento.ru)
 * @package Mygento_Shipment
 */

namespace Mygento\Shipment\Model;

use Mygento\Shipment\Api\DimensionInterface;
use Mygento\Shipment\Api\Service\CalculateInterface;
use Mygento\Shipment\Api\Service\OrderInterface;

abstract class AbstractService implements CalculateInterface, OrderInterface
{
    /**
     * @var \Mygento\Shipment\Helper\Data
     */
    protected $helper;

    /**
     * @var \Mygento\Shipment\Model\Service
     */
    protected $baseService;

    /**
     * @var \Magento\Framework\Api\SearchCriteriaBuilder
     */
    protected $searchBuilder;

    /**
     * @param \Mygento\Shipment\Model\Service $service
     */
    public function __construct(
        \Mygento\Shipment\Model\Service $service,
        \Mygento\Shipment\Helper\Data $helper,
        \Magento\Framework\Api\SearchCriteriaBuilder $searchBuilder
    ) {
        $this->baseService = $service;
        $this->searchBuilder = $searchBuilder;
        $this->helper = $helper;
    }

    /**
     * @return float
     */
    public function getSizeRatio(): float
    {
        return (float) $this->helper->getConfig(DimensionInterface::SIZE);
    }

    /**
     * @return float
     */
    public function getWeightRatio(): float
    {
        return (float) $this->helper->getConfig(DimensionInterface::WEIGHT);
    }

    /**
     * @return \Mygento\Shipment\Api\Data\CalculateResultInterface
     */
    public function getCalculateResultInstance()
    {
        return $this->baseService->getCalculateResultInstance();
    }
}
