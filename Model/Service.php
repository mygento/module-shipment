<?php

/**
 * @author Mygento Team
 * @copyright 2016-2020 Mygento (https://www.mygento.ru)
 * @package Mygento_Shipment
 */

namespace Mygento\Shipment\Model;

class Service implements \Mygento\Shipment\Api\Service\BaseInterface
{
    /**
     * @var \Mygento\Shipment\Api\PointManagerInterface
     */
    private $pointManager;

    /**
     * @var \Mygento\Shipment\Api\Data\CalculateResultInterfaceFactory
     */
    private $resultFactory;

    /**
     * @param \Mygento\Shipment\Api\PointManagerInterface $pointManager
     * @param \Mygento\Shipment\Api\Data\CalculateResultInterfaceFactory $resultFactory
     */
    public function __construct(
        \Mygento\Shipment\Api\PointManagerInterface $pointManager,
        \Mygento\Shipment\Api\Data\CalculateResultInterfaceFactory $resultFactory
    ) {
        $this->resultFactory = $resultFactory;
        $this->pointManager = $pointManager;
    }

    /**
     * @return \Mygento\Shipment\Api\Data\CalculateResultInterface
     */
    public function getCalculateResultInstance()
    {
        return $this->resultFactory->create();
    }

    /**
     * @return \Mygento\Shipment\Api\PointManagerInterface
     */
    public function getPointManager()
    {
        return $this->pointManager;
    }

    /**
     * @param string $code
     * @param int $estimate
     * @return string
     */
    public function convertEstimateToDate(string $code, int $estimate = 0): string
    {
        return date('Y-m-d', strtotime('+' . $estimate . ' day'));
    }
}
