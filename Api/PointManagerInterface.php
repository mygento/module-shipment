<?php

/**
 * @author Mygento Team
 * @copyright 2016-2021 Mygento (https://www.mygento.ru)
 * @package Mygento_Shipment
 */

namespace Mygento\Shipment\Api;

interface PointManagerInterface
{
    /**
     * Update all points
     */
    public function updatePoints();

    /**
     * @return \Mygento\Shipment\Api\Data\PointInterface
     */
    public function getPoint(): Data\PointInterface;

    /**
     * @param string $carrier
     */
    public function cleanByCarrier(string $carrier);

    /**
     * @return string
     */
    public function getTable(): string;

    /**
     * @param string $carrier
     * @param string $city
     * @return \Mygento\Shipment\Api\Data\PointInterface[]
     */
    public function getPointsByCity(string $carrier, string $city);

    /**
     * @param string $carrier
     * @param string $code
     * @return false|\Mygento\Shipment\Api\Data\PointInterface
     */
    public function getPointById(string $carrier, string $code);

    /**
     * @param \Magento\Quote\Api\Data\CartInterface|\Magento\Sales\Api\Data\OrderInterface $entity
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     * @return \Mygento\Shipment\Api\Data\PointInterface
     */
    public function getPointByEntity($entity): \Mygento\Shipment\Api\Data\PointInterface;

    /**
     * @return \Magento\Framework\DB\Adapter\AdapterInterface
     */
    public function getConnection();
}
