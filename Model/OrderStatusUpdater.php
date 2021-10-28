<?php

/**
 * @author Mygento Team
 * @copyright 2016-2021 Mygento (https://www.mygento.ru)
 * @package Mygento_Shipment
 */

namespace Mygento\Shipment\Model;

use Magento\Sales\Model\Order;
use Mygento\Base\Model\OrderRepository;
use Mygento\Shipment\Api\OrderStatusUpdaterInterface;

class OrderStatusUpdater implements OrderStatusUpdaterInterface
{
    /**
     * @var OrderRepository
     */
    private $orderRepository;

    /**
     * @param OrderRepository $orderRepository
     */
    public function __construct(OrderRepository $orderRepository)
    {
        $this->orderRepository = $orderRepository;
    }

    /**
     * @param Order $order
     * @param string $status
     * @param string $comment
     * @throws \Magento\Framework\Exception\AlreadyExistsException
     * @throws \Magento\Framework\Exception\InputException
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function update(Order $order, string $status, string $comment = '')
    {
        $order->addStatusToHistory($status, $comment);
        $this->orderRepository->save($order);
        $this->orderRepository->clearCache();
    }
}
