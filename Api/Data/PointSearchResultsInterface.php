<?php

/**
 * @author Mygento Team
 * @copyright 2016-2025 Mygento (https://www.mygento.com)
 * @package Mygento_Shipment
 */

namespace Mygento\Shipment\Api\Data;

use Magento\Framework\Api\SearchResultsInterface;

interface PointSearchResultsInterface extends SearchResultsInterface
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
