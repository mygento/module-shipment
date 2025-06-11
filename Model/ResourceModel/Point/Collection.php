<?php

/**
 * @author Mygento Team
 * @copyright 2016-2025 Mygento (https://www.mygento.com)
 * @package Mygento_Shipment
 */

namespace Mygento\Shipment\Model\ResourceModel\Point;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use Mygento\Shipment\Model\Point;
use Mygento\Shipment\Model\ResourceModel\Point as PointResource;

class Collection extends AbstractCollection
{
    /** @var string */
    protected $_idFieldName = PointResource::TABLE_PRIMARY_KEY;

    /**
     * Define resource model
     */
    protected function _construct()
    {
        $this->_init(
            Point::class,
            PointResource::class,
        );
    }
}
