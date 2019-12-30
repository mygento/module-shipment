<?php

/**
 * @author Mygento Team
 * @copyright 2016-2019 Mygento (https://www.mygento.ru)
 * @package Mygento_Shipment
 */

namespace Mygento\Shipment\Model;

use Mygento\Shipment\Api\Data\CalculateRequestInterface;
use Mygento\Shipment\Api\Service\CalculateInterface;
use Mygento\Shipment\Api\Service\OrderInterface;

class Service implements CalculateInterface, OrderInterface
{
    /**
     * @var \Mygento\Shipment\Api\Data\CalculateResultInterfaceFactory
     */
    private $resultFactory;

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

    /**
     * @param CalculateRequestInterface $request
     * @return array
     */
    public function calculateDeliveryCost(CalculateRequestInterface $request): array
    {
        return [];
    }

    /**
     * @param int|string $orderId
     */
    public function orderCancel($orderId)
    {
    }

    /**
     * @param \Magento\Sales\Model\Order $order
     * @param array $data
     */
    public function orderCreate(\Magento\Sales\Model\Order $order, $data = [])
    {
    }

    /**
     * @return float
     */
    public function getWeightRatio(): float
    {
        return 1;
    }

    /**
     * @return float
     */
    public function getSizeRatio(): float
    {
        return 1;
    }
}
