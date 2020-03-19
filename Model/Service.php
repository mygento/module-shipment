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
     * @var \Mygento\Shipment\Api\Data\EstimateTimeInterfaceFactory
     */
    private $timeFactory;

    /**
     * @var \Magento\Sales\Model\Order\Email\Sender\ShipmentSender
     */
    private $shipmentSender;

    /**
     * @var \Magento\Framework\DB\TransactionFactory
     */
    private $transactionFactory;

    /**
     * @var \Magento\Sales\Model\Order\ShipmentFactory
     */
    private $shipmentFactory;

    /**
     * @var \Magento\Sales\Model\Order\Shipment\TrackFactory
     */
    private $trackFactory;

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
     * @param \Magento\Sales\Model\Order\Email\Sender\ShipmentSender $shipmentSender
     * @param \Mygento\Shipment\Api\Data\CalculateResultInterfaceFactory $resultFactory
     * @param \Mygento\Shipment\Api\Data\EstimateTimeInterfaceFactory $timeFactory
     * @param \Magento\Sales\Model\Order\ShipmentFactory $shipmentFactory
     * @param \Magento\Sales\Model\Order\Shipment\TrackFactory $trackFactory
     * @param \Magento\Framework\DB\TransactionFactory $transactionFactory
     */
    public function __construct(
        \Mygento\Shipment\Api\PointManagerInterface $pointManager,
        \Mygento\Base\Helper\Discount $taxHelper,
        \Mygento\Shipment\Helper\Dimensions $dimensionHelper,
        \Magento\Sales\Model\Order\Email\Sender\ShipmentSender $shipmentSender,
        \Mygento\Shipment\Api\Data\CalculateResultInterfaceFactory $resultFactory,
        \Mygento\Shipment\Api\Data\EstimateTimeInterfaceFactory $timeFactory,
        \Magento\Sales\Model\Order\ShipmentFactory $shipmentFactory,
        \Magento\Sales\Model\Order\Shipment\TrackFactory $trackFactory,
        \Magento\Framework\DB\TransactionFactory $transactionFactory
    ) {
        $this->pointManager = $pointManager;
        $this->taxHelper = $taxHelper;
        $this->resultFactory = $resultFactory;
        $this->dimensionHelper = $dimensionHelper;
        $this->trackFactory = $trackFactory;
        $this->shipmentFactory = $shipmentFactory;
        $this->transactionFactory = $transactionFactory;
        $this->shipmentSender = $shipmentSender;
        $this->timeFactory = $timeFactory;
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
        return $this->taxHelper->getRecalculated(
            $order,
            $helper->getConfig('tax_options/tax_products'),
            $helper->getConfig('tax_product_attr'),
            $helper->getConfig('tax_options/tax_shipping')
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
        $shipping = $order->getShippingMethod(true);

        $data = [
            'carrier_code' => $shipping->getCarrierCode(),
            'title' => $order->getShippingDescription(),
            'number' => $trackingCode,
        ];

        // Создание новой доставки
        if (!$order->canShip()) {
            throw \Magento\Framework\Exception\CouldNotSaveException(__('Cannot do shipment for the order.'));
        }

        // Сохранение кода для созданной доставки
        if ($order->getShipmentsCollection()->count() > 0) {
            $shipment = $order->getShipmentsCollection()->getFirstItem();

            if (count($shipment->getAllTracks()) !== 0) {
                throw \Magento\Framework\Exception\CouldNotSaveException(__('Cannot do shipment for the order.'));
            }

            $shipment->addTrack($this->trackFactory->create()->addData($data));
            $transaction = $this->transactionFactory->create();
            $transaction->addObject($shipment);
            $transaction->addObject($shipment->getOrder());
            $transaction->save();

            return $shipment;
        }

        $items = [];
        foreach ($order->getAllItems() as $item) {
            if (!$item->getQtyToShip() || $item->getIsVirtual()) {
                continue;
            }
            $items[$item->getId()] = [
                'order_item_id' => $item->getId(),
                'qty' => $item->getQtyToShip(),
            ];
        }

        $shipment = $this->shipmentFactory->create($order, $items, [$data]);

        $shipment->register();
        $shipment->getOrder()->setCustomerNoteNotify($notify);
        $shipment->addComment(__('Order shipped by %1', $shipping->getCarrierCode()));
        $shipment->getOrder()->setIsInProcess(true);
        $transaction = $this->transactionFactory->create();
        $transaction->addObject($shipment);
        $transaction->addObject($shipment->getOrder());
        $transaction->save();

        if ($notify) {
            $this->shipmentSender->send($shipment);
        }

        return $shipment;
    }
}
