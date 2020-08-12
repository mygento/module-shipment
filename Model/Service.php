<?php

/**
 * @author Mygento Team
 * @copyright 2016-2020 Mygento (https://www.mygento.ru)
 * @package Mygento_Shipment
 */

namespace Mygento\Shipment\Model;

use Magento\Sales\Api\Data\OrderInterface;

/**
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
 */
class Service implements \Mygento\Shipment\Api\Service\BaseInterface
{
    /**
     * @var \Mygento\Shipment\Model\Service\Tracking
     */
    private $tracking;

    /**
     * @var \Mygento\Shipment\Api\Data\EstimateTimeInterfaceFactory
     */
    private $timeFactory;

    /**
     * @var \Mygento\Shipment\Helper\Dimensions
     */
    private $dimensionHelper;

    /**
     * @var \Mygento\Shipment\Api\PointManagerInterface
     */
    private $pointManager;

    /**
     * @var \Mygento\Shipment\Api\Data\CalculateResultInterfaceFactory
     */
    private $resultFactory;

    /**
     * @var \Mygento\Base\Helper\Discount
     */
    private $taxHelper;

    /**
     * @param \Mygento\Shipment\Api\PointManagerInterface $pointManager
     * @param \Mygento\Base\Helper\Discount $taxHelper
     * @param \Mygento\Shipment\Helper\Dimensions $dimensionHelper
     * @param \Mygento\Shipment\Model\Service\Tracking $tracking
     * @param \Mygento\Shipment\Api\Data\CalculateResultInterfaceFactory $resultFactory
     * @param \Mygento\Shipment\Api\Data\EstimateTimeInterfaceFactory $timeFactory
     */
    public function __construct(
        \Mygento\Shipment\Api\PointManagerInterface $pointManager,
        \Mygento\Base\Helper\Discount $taxHelper,
        \Mygento\Shipment\Helper\Dimensions $dimensionHelper,
        \Mygento\Shipment\Model\Service\Tracking $tracking,
        \Mygento\Shipment\Api\Data\CalculateResultInterfaceFactory $resultFactory,
        \Mygento\Shipment\Api\Data\EstimateTimeInterfaceFactory $timeFactory
    ) {
        $this->pointManager = $pointManager;
        $this->taxHelper = $taxHelper;
        $this->resultFactory = $resultFactory;
        $this->dimensionHelper = $dimensionHelper;
        $this->timeFactory = $timeFactory;
        $this->tracking = $tracking;
    }

    /**
     * @return \Mygento\Shipment\Api\Data\CalculateResultInterface
     */
    public function getCalculateResultInstance()
    {
        return $this->resultFactory->create();
    }

    /**
     * @param string $from
     * @param string $to
     * @return \Mygento\Shipment\Api\Data\EstimateTimeInterface
     */
    public function getEstimateTimeInstance(string $from, string $to)
    {
        /** @var \Mygento\Shipment\Api\Data\EstimateTimeInterface $model */
        $model = $this->timeFactory->create();
        $model->setFrom($from);
        $model->setTo($to);

        return $model;
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
     *
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function convertEstimateToDate(string $code, int $estimate = 0): string
    {
        return date('Y-m-d', strtotime('+' . $estimate . ' day'));
    }

    /**
     * @return \Mygento\Base\Helper\Discount
     */
    public function getTaxHelper()
    {
        return $this->taxHelper;
    }

    /**
     * @param \Magento\Sales\Api\Data\OrderInterface $order
     * @param \Mygento\Shipment\Helper\Data $helper
     * @return array
     */
    public function getTaxInfoForItems(
        OrderInterface $order,
        \Mygento\Shipment\Helper\Data $helper
    ) {
        $attributeCode = '';
        if (!$helper->isSameTaxPerProduct($order->getStoreId())) {
            $attributeCode = $helper->getProductTaxAttribute($order->getStoreId()) ?: '';
        }

        return $this->taxHelper->getRecalculated(
            $order,
            $helper->getAllProductTax($order->getStoreId()),
            $attributeCode,
            $helper->getTaxForShipping($order->getStoreId())
        );
    }

    /**
     * @return \Mygento\Shipment\Helper\Dimensions
     */
    public function getDimensionHelper()
    {
        return $this->dimensionHelper;
    }

    /**
     * Добавление кода отслеживания
     *
     * @param \Magento\Sales\Model\Order $order
     * @param string $trackingCode
     * @param bool $notify
     *
     * @throws \Magento\Framework\Exception\CouldNotSaveException
     * @return \Magento\Sales\Api\Data\ShipmentInterface
     */
    public function setTracking(
        \Magento\Sales\Model\Order $order,
        string $trackingCode,
        bool $notify = false
    ) {
        return $this->tracking->setTracking($order, $trackingCode, $notify);
    }

    /**
     * @param string $trackingCode
     * @param string $carrier
     * @throws \Magento\Framework\Exception\NotFoundException
     * @return \Magento\Sales\Model\Order
     */
    public function findOrderByTracking(string $trackingCode, string $carrier)
    {
        return $this->tracking->findOrderByTracking($trackingCode, $carrier);
    }
}
