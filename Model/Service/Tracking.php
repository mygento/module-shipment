<?php

/**
 * @author Mygento Team
 * @copyright 2016-2020 Mygento (https://www.mygento.ru)
 * @package Mygento_Shipment
 */

namespace Mygento\Shipment\Model\Service;

use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Sales\Api\Data\ShipmentTrackInterface;

class Tracking
{
    /**
     * @var \Magento\Framework\DB\TransactionFactory
     */
    private $transactionFactory;

    /**
     * @var \Magento\Sales\Model\Order\Shipment\TrackFactory
     */
    private $trackFactory;

    /**
     * @var \Magento\Sales\Model\Order\ShipmentFactory
     */
    private $shipmentFactory;

    /**
     * @var \Magento\Framework\Api\SearchCriteriaBuilder
     */
    private $builder;

    /**
     * @var \Magento\Sales\Model\Order\Email\Sender\ShipmentSender
     */
    private $shipmentSender;

    /**
     * @var \Magento\Sales\Api\ShipmentTrackRepositoryInterface
     */
    private $trackRepo;

    /**
     * @var \Magento\Sales\Api\OrderRepositoryInterface
     */
    private $orderRepo;

    /**
     * @param \Magento\Sales\Api\OrderRepositoryInterface $orderRepo
     * @param \Magento\Sales\Api\ShipmentTrackRepositoryInterface $trackRepo
     * @param \Magento\Sales\Model\Order\Email\Sender\ShipmentSender $shipmentSender
     * @param \Magento\Framework\Api\SearchCriteriaBuilder $builder
     * @param \Magento\Sales\Model\Order\ShipmentFactory $shipmentFactory
     * @param \Magento\Sales\Model\Order\Shipment\TrackFactory $trackFactory
     * @param \Magento\Framework\DB\TransactionFactory $transactionFactory
     */
    public function __construct(
        \Magento\Sales\Api\OrderRepositoryInterface $orderRepo,
        \Magento\Sales\Api\ShipmentTrackRepositoryInterface $trackRepo,
        \Magento\Sales\Model\Order\Email\Sender\ShipmentSender $shipmentSender,
        \Magento\Framework\Api\SearchCriteriaBuilder $builder,
        \Magento\Sales\Model\Order\ShipmentFactory $shipmentFactory,
        \Magento\Sales\Model\Order\Shipment\TrackFactory $trackFactory,
        \Magento\Framework\DB\TransactionFactory $transactionFactory
    ) {
        $this->orderRepo = $orderRepo;
        $this->trackRepo = $trackRepo;
        $this->shipmentSender = $shipmentSender;
        $this->builder = $builder;
        $this->shipmentFactory = $shipmentFactory;
        $this->trackFactory = $trackFactory;
        $this->transactionFactory = $transactionFactory;
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

        // Сохранение кода для созданной доставки
        if ($order->hasShipments()) {
            $shipment = $order->getShipmentsCollection()->getFirstItem();

            if (count($shipment->getAllTracks()) !== 0) {
                throw new \Magento\Framework\Exception\CouldNotSaveException(__('Cannot do shipment for the order.'));
            }

            $shipment->addTrack($this->trackFactory->create()->addData($data));
            $transaction = $this->transactionFactory->create();
            $transaction->addObject($shipment);
            $transaction->addObject($shipment->getOrder());
            $transaction->save();

            return $shipment;
        }

        // Создание новой доставки
        if (!$order->canShip()) {
            throw new \Magento\Framework\Exception\CouldNotSaveException(__('Cannot do shipment for the order.'));
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

    /**
     * @param string $trackingCode
     * @param string $carrier
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     * @return \Magento\Sales\Model\Order
     */
    public function findOrderByTracking(string $trackingCode, string $carrier)
    {
        $this->builder->addFilter(ShipmentTrackInterface::TRACK_NUMBER, $trackingCode);
        $this->builder->addFilter(ShipmentTrackInterface::CARRIER_CODE, $carrier);
        $result = $this->trackRepo->getList($this->builder->create());

        if ($result->getTotalCount() < 1) {
            throw new NoSuchEntityException(
                __("The entity that was requested doesn't exist. Verify the entity and try again.")
            );
        }

        $items = $result->getItems();

        /** @var ShipmentTrackInterface $track */
        $track = reset($items);

        return $this->orderRepo->get($track->getOrderId());
    }
}
