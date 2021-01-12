<?php

/**
 * @author Mygento Team
 * @copyright 2016-2020 Mygento (https://www.mygento.ru)
 * @package Mygento_Shipment
 */

namespace Mygento\Shipment\Api\Service;

interface AutoshipInterface
{
    /**
     * @param string[] $statuses
     * @param array $filters
     * @param int|string $storeId
     */
    public function getOrdersByStatuses(array $statuses, array $filters = [], $storeId = null);

    /**
     * @param string $field
     * @param mixed $value
     * @param string $condition
     * @return \Magento\Framework\Api\Filter
     */
    public function createFilter(string $field, $value, string $condition = 'eq');
}
