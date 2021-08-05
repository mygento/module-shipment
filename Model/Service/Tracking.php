<?php

/**
 * @author Mygento Team
 * @copyright 2016-2021 Mygento (https://www.mygento.ru)
 * @package Mygento_Shipment
 */

namespace Mygento\Shipment\Model\Service;

use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Sales\Api\Data\ShipmentTrackInterface;

/**
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
 */
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
     * @var \Magento\Framework\Event\ManagerInterface
     */
    private $eventManager;

    /**
     * @param \Magento\Sales\Api\OrderRepositoryInterface $orderRepo
     * @param \Magento\Sales\Api\ShipmentTrackRepositoryInterface $trackRepo
     * @param \Magento\Sales\Model\Order\Email\Sender\ShipmentSender $shipmentSender
     * @param \Magento\Framework\Api\SearchCriteriaBuilder $builder
     * @param \Magento\Framework\Event\ManagerInterface $eventManager
     * @param \Magento\Sales\Model\Order\ShipmentFactory $shipmentFactory
     * @param \Magento\Sales\Model\Order\Shipment\TrackFactory $trackFactory
     * @param \Magento\Framework\DB\TransactionFactory $transactionFactory
     */
    public function __construct(
        \Magento\Sales\Api\OrderRepositoryInterface $orderRepo,
        \Magento\Sales\Api\ShipmentTrackRepositoryInterface $trackRepo,
        \Magento\Sales\Model\Order\Email\Sender\ShipmentSender $shipmentSender,
        \Magento\Framework\Api\SearchCriteriaBuilder $builder,
        \Magento\Framework\Event\ManagerInterface $eventManager,
        \Magento\Sales\Model\Order\ShipmentFactory $shipmentFactory,
        \Magento\Sales\Model\Order\Shipment\TrackFactory $trackFactory,
        \Magento\Framework\DB\TransactionFactory $transactionFactory
    ) {
        $this->orderRepo = $orderRepo;
        $this->trackRepo = $trackRepo;
        $this->shipmentSender = $shipmentSender;
        $this->builder = $builder;
        $this->eventManager = $eventManager;
        $this->shipmentFactory = $shipmentFactory;
        $this->trackFactory = $trackFactory;
        $this->transactionFactory = $transactionFactory;
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
     * @return \Magento\Sales\Api\Data\ShipmentInterface
     */
    public function setTracking(
        \Magento\Sales\Model\Order $order,
        string $carrierCode,
        string $trackingCode,
        bool $notify = false
    ) {
        $data = [
            'carrier_code' => $carrierCode,
            'title' => $order->getShippingDescription(),
            'number' => $trackingCode,
        ];

        // Сохранение кода для созданной доставки
        if ($order->hasShipments()) {
            /** @var \Magento\Sales\Model\Order\Shipment $shipment */
            $shipment = $order->getShipmentsCollection()->getFirstItem();

            if (count($shipment->getAllTracks()) !== 0) {
                return $this->matchExistingTrack($shipment, $trackingCode, $carrierCode);
            }

            $this->eventManager->dispatch('mygento_shipment_track_assign', [
                'shipment' => $shipment,
                'order' => $shipment->getOrder(),
                'tracking' => $trackingCode,
            ]);

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
            $items[$item->getId()] = (int) $item->getQtyToShip();
        }

        /** @var \Magento\Sales\Model\Order\Shipment $shipment */
        $shipment = $this->shipmentFactory->create($order, $items, [$data]);

        $shipment->register();
        $shipment->getOrder()->setCustomerNoteNotify($notify);
        $shipment->addComment(__('Order shipped by %1', $carrierCode));
        $shipment->getOrder()->setIsInProcess(true);

        $this->eventManager->dispatch('mygento_shipment_track_assign', [
            'shipment' => $shipment,
            'order' => $shipment->getOrder(),
            'tracking' => $trackingCode,
        ]);

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
     * @return \Magento\Sales\Api\Data\OrderInterface|\Magento\Sales\Model\Order
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

    private function matchExistingTrack($shipment, $trackingCode, $carrierCode)
    {
        foreach ($shipment->getAllTracks() as $t) {
            /** @var \Magento\Sales\Model\Order\Shipment\Track $t */
            if ($t->getNumber() === $trackingCode && $t->getCarrierCode() === $carrierCode) {
                return $shipment;
            }
        }

        throw new \Magento\Framework\Exception\CouldNotSaveException(__('Cannot do shipment for the order.'));
    }
}
