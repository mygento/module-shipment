<?php

/**
 * @author Mygento Team
 * @copyright 2016-2019 Mygento (https://www.mygento.ru)
 * @package Mygento_Shipment
 */

namespace Mygento\Shipment\Model;

class Service implements \Mygento\Shipment\Api\Service\BaseInterface
{
    /**
     * @var \Mygento\Shipment\Api\Data\CalculateResultInterfaceFactory
     */
    private $resultFactory;

    /**
     * @param \Mygento\Shipment\Api\Data\CalculateResultInterfaceFactory $resultFactory
     */
    public function __construct(
        \Mygento\Shipment\Api\Data\CalculateResultInterfaceFactory $resultFactory
    ) {
        $this->resultFactory = $resultFactory;
    }

    /**
     * @return \Mygento\Shipment\Api\Data\CalculateResultInterface
     */
    public function getCalculateResultInstance()
    {
        return $this->resultFactory->create();
    }
}
