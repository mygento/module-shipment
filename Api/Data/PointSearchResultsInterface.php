<?php

/**
 * @author Mygento Team
 * @copyright 2016-2019 Mygento (https://www.mygento.ru)
 * @package Mygento_Shipment
 */

namespace Mygento\Shipment\Api\Data;

interface PointSearchResultsInterface extends \Magento\Framework\Api\SearchResultsInterface
{
    /**
     * Get list of Point
     * @return \Mygento\Shipment\Api\Data\PointInterface[]
     */
    public function getItems();

    /**
     * Set list of Point
     * @param \Mygento\Shipment\Api\Data\PointInterface[] $items
     */
    public function setItems(array $items);
}
