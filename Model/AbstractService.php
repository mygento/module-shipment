<?php

/**
 * @author Mygento Team
 * @copyright 2016-2020 Mygento (https://www.mygento.ru)
 * @package Mygento_Shipment
 */

namespace Mygento\Shipment\Model;

use Mygento\Shipment\Api\DimensionInterface;
use Mygento\Shipment\Api\Service\CalculateInterface;
use Mygento\Shipment\Api\Service\OrderInterface;

/**
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
 */
abstract class AbstractService implements CalculateInterface, OrderInterface
{
    /** @var float */
    protected $weightCoefficient = 1.0;

    /** @var float */
    protected $sizeCoefficient = 1.0;

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
     * @param \Mygento\Shipment\Model\Service $baseService
     * @param \Mygento\Shipment\Helper\Data $helper
     * @param \Magento\Framework\Api\SearchCriteriaBuilder $searchBuilder
     */
    public function __construct(
        \Mygento\Shipment\Model\Service $baseService,
        \Mygento\Shipment\Helper\Data $helper,
        \Magento\Framework\Api\SearchCriteriaBuilder $searchBuilder
    ) {
        $this->baseService = $baseService;
        $this->searchBuilder = $searchBuilder;
        $this->helper = $helper;
    }

    /**
     * @param mixed|null $scopeCode
     * @return float
     */
    public function getSizeRatio($scopeCode = null): float
    {
        return (float) $this->helper->getConfig(DimensionInterface::SIZE, $scopeCode)
            * $this->sizeCoefficient;
    }

    /**
     * @param mixed|null $scopeCode
     * @return float
     */
    public function getWeightRatio($scopeCode = null): float
    {
        return (float) $this->helper->getConfig(DimensionInterface::WEIGHT, $scopeCode)
            * $this->weightCoefficient;
    }

    /**
     * @return \Mygento\Shipment\Api\Data\CalculateResultInterface
     */
    public function getCalculateResultInstance()
    {
        return $this->baseService->getCalculateResultInstance();
    }

    /**
     * @return \Mygento\Shipment\Api\PointManagerInterface
     */
    public function getPointManager()
    {
        return $this->baseService->getPointManager();
    }

    /**
     * @param string $code
     * @param int $estimate
     * @return string
     */
    public function convertEstimateToDate(string $code, int $estimate): string
    {
        return $this->baseService->convertEstimateToDate($code, $estimate);
    }

    /**
     * @return \Mygento\Base\Helper\Discount
     */
    public function getTaxHelper()
    {
        return $this->baseService->getTaxHelper();
    }

    /**
     * @param \Magento\Sales\Api\Data\OrderInterface $order
     * @param \Mygento\Shipment\Helper\Data $helper
     */
    public function getTaxInfoForItems(
        \Magento\Sales\Api\Data\OrderInterface $order,
        \Mygento\Shipment\Helper\Data $helper
    ) {
        return $this->baseService->getTaxInfoForItems($order, $helper);
    }

    /**
     * @return \Mygento\Shipment\Helper\Dimensions
     */
    public function getDimensionHelper()
    {
        return $this->baseService->getDimensionHelper();
    }

    /**
     * @inheridoc
     */
    public function getOrderRepository()
    {
        return $this->baseService->getOrderRepository();
    }

    /**
     * Добавление кода отслеживания
     *
     * @param \Magento\Sales\Model\Order $order
     * @param string $carrierCode
     * @param string $trackingCode
     * @param bool $notify
     *
     * @throws \Magento\Framework\Exception\CouldNotSaveException
     */
    public function setTracking(
        \Magento\Sales\Model\Order $order,
        string $carrierCode,
        string $trackingCode,
        bool $notify = false
    ) {
        return $this->baseService->setTracking($order, $carrierCode, $trackingCode, $notify);
    }

    /**
     * @param string $from
     * @param string $to
     * @return \Mygento\Shipment\Api\Data\EstimateTimeInterface
     */
    public function getEstimateTimeInstance(string $from, string $to)
    {
        return $this->baseService->getEstimateTimeInstance($from, $to);
    }

    /**
     * @param string $trackingCode
     * @param string $carrier
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     * @return \Magento\Sales\Model\Order
     */
    public function findOrderByTracking(string $trackingCode, string $carrier)
    {
        return $this->baseService->findOrderByTracking($trackingCode, $carrier);
    }

    /**
     * @param \Magento\Sales\Model\Order $order
     * @param array $messages
     */
    public function failOrder($order, array $messages)
    {
        $fail = $this->helper->getShipmentFailStatus($order->getStoreId()) ?? false;
        $order->addCommentToStatusHistory(
            __('Order ship fail by %1: %2', $this->helper->getCode(), implode(PHP_EOL, $messages)),
            $fail
        );
        $this->getOrderRepository()->save($order);
    }
}
