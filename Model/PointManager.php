<?php

/**
 * @author Mygento Team
 * @copyright 2016-2019 Mygento (https://www.mygento.ru)
 * @package Mygento_Shipment
 */

namespace Mygento\Shipment\Model;

use Magento\Framework\Exception\LocalizedException;
use Mygento\Shipment\Api\Data\PointInterface;
use Mygento\Shipment\Api\Data\PointProviderInterface;

class PointManager implements \Mygento\Shipment\Api\PointManagerInterface
{
    /**
     * @var \Mygento\Shipment\Model\ResourceModel\Point\CollectionFactory
     */
    private $collectionFactory;

    /**
     * @var \Mygento\Shipment\Model\ResourceModel\Point
     */
    private $point;

    /**
     * @var \Mygento\Shipment\Api\Data\PointInterfaceFactory
     */
    private $pointFactory;

    /**
     * @var array
     */
    private $carrierPool;

    /**
     * @var \Mygento\Shipment\Helper\Data
     */
    private $helper;

    /**
     * @param \Mygento\Shipment\Helper\Data $helper
     * @param \Mygento\Shipment\Model\ResourceModel\Point\CollectionFactory $collectionFactory
     * @param \Mygento\Shipment\Api\Data\PointInterfaceFactory $pointFactory
     * @param \Mygento\Shipment\Model\ResourceModel\Point $point
     * @param array $carrierPool
     */
    public function __construct(
        \Mygento\Shipment\Helper\Data $helper,
        \Mygento\Shipment\Model\ResourceModel\Point\CollectionFactory $collectionFactory,
        \Mygento\Shipment\Api\Data\PointInterfaceFactory $pointFactory,
        \Mygento\Shipment\Model\ResourceModel\Point $point,
        array $carrierPool = []
    ) {
        $this->helper = $helper;
        $this->pointFactory = $pointFactory;
        $this->point = $point;
        $this->collectionFactory = $collectionFactory;
        $this->carrierPool = $carrierPool;
    }

    /**
     * @throws LocalizedException
     */
    public function updatePoints()
    {
        foreach ($this->carrierPool as $provider) {
            try {
                if (!$provider instanceof PointProviderInterface) {
                    throw new LocalizedException(__('Invalid point provider'));
                }
                $provider->updatePoints();
            } catch (\Exception $e) {
                $this->helper->error($e->getMessage(), ['exception' => $e]);
            }
        }
    }

    /**
     * @return PointInterface
     */
    public function getPoint(): PointInterface
    {
        return $this->pointFactory->create();
    }

    /**
     * @param string $carrier
     */
    public function cleanByCarrier(string $carrier)
    {
        $connection = $this->point->getConnection();
        $connection->delete($this->point->getMainTable(), [PointInterface::PROVIDER . '=?' => $carrier]);
    }

    /**
     * @return string
     */
    public function getTable(): string
    {
        return $this->point->getMainTable();
    }

    /**
     * @param string $carrier
     * @param string $city
     * @return \Mygento\Shipment\Api\Data\PointInterface[]
     */
    public function getPointsByCity(string $carrier, string $city)
    {
        $collection = $this->collectionFactory->create();
        $collection->addFieldToFilter(PointInterface::IS_ACTIVE, 1);
        $collection->addFieldToFilter(PointInterface::PROVIDER, $carrier);
        $collection->addFieldToFilter(PointInterface::CITY, $city);

        return $collection->getItems();
    }
}
